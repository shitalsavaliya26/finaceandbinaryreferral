<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StackingPool;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Package;
use App\Models\CommissionWalletHistory;
use App\Models\UserWallet;
use App\Models\ReferralCommission;
use App\Models\Setting;
use App\Models\NftWalletHistory;

class CalculateReferralCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:directreferral {pool_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate users direct referral commission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        set_time_limit(0);
        \DB::transaction(function () {
            $result_date = Carbon::today()->format('Y-m-d');

            StackingPool::where('status',0)->update(['status' => 1]);
            $stakingpools = StackingPool::where('status',1)->where('id',$this->argument('pool_id'))->get();
            foreach($stakingpools as $stakingpool){
                $user = $stakingpool->user_detail;
                $upline_users = Helper::getUplineSponsor($user);
                $last_comm_percent = 0;
                $sum_rank_percent = 0;

                foreach ($upline_users as $key => $value) {
                    // echo $value->id.'--'.$stakingpool->user_id.'=='.$stakingpool->id.'=='.$result_date;die('testq');
                    if(count($value->active_staking_history) == 0){
                        continue;
                    }
                    $todaysPool = ReferralCommission::where(["user_id" => $value->id, "from_user_id" => $stakingpool->user_id,'stacking_pool_id' => $stakingpool->id])->whereDate('created_at',$result_date)->count();
                    if($todaysPool > 0){
                        continue;
                    }

                    $package_detail = Package::where('amount','<=',$value->userwallet->stacking_pool)->orderBy('amount','desc')->first();
                   // print($value->level.' < '.$value->userwallet->stacking_pool); 
                    // echo $value->username.' '.$value->level.'~';
                    // echo $value->userwallet->stacking_pool;
                    if(!$package_detail){
                        continue;
                    }

                    $level_commission_percent = 0;
                    $total_commission = $package_detail->direct_refferal; //$value->package_detail->direct_refferal;
            
                    if($total_commission <= 0){
                        continue;
                    }
                    if($value->level == '1'){
                        $level_commission_percent = $package_detail->direct_refferal;
                    }else if($value->level!= '1'){
                        $level_commission_percent = $package_detail->direct_refferal - $sum_rank_percent;
                        if($value->userwallet->stacking_pool < $stakingpool->user_detail->userwallet->stacking_pool){
                            continue;
                        }
                    }   
                    
                    if($level_commission_percent <= 0) {
                        continue;
                    }
                    $sum_rank_percent = $sum_rank_percent + $level_commission_percent; 
                    $commission_percent = $level_commission_percent / 100;

                    $commission_amount = round($stakingpool->amount * $commission_percent,2); 
                    $commission_wallet = UserWallet::where('user_id',$value->id)->first();
                    $nft_commission = Setting::where('key','nft_commission')->value('value');
                    $nft_commission = ($nft_commission > 0) ? $nft_commission/100 : 0.2; 
                    $nft_commission_amount = $commission_amount * $nft_commission;
                    $commission_amount_actual = $commission_amount - $nft_commission_amount;
                    
                    // echo "=".$sum_rank_percent."---".$level_commission_percent.' '.$commission_amount; 
                    // echo "<pre><br>";

                    $history_data["type"] = "1";
                    $history_data["amount"] = $nft_commission_amount;
                    $history_data["user_id"] = $value->id;
                    $history_data["description"] = 'Referral commission from '.$stakingpool->user_detail->username;
                    $history_data["description_cn"] = '直系推荐佣金从 '.$stakingpool->user_detail->username;
                    $history_data["final_amount"] = $commission_wallet->nft_wallet + $nft_commission_amount;

                    NftWalletHistory::create($history_data);
                    $commission_wallet->increment('nft_wallet',$nft_commission_amount);

                    $history_data["type"] = "1";
                    $history_data["amount"] = $commission_amount_actual;
                    $history_data["user_id"] = $value->id;
                    $history_data["from_user_id"] = $stakingpool->user_id;
                    $history_data["commission_type"] = 'referral';
                    $history_data["description"] = 'Referral commission from '.$stakingpool->user_detail->username;
                    $history_data["description_cn"] = '直系推荐佣金从'.$stakingpool->user_detail->username;
                    $history_data["final_amount"] = $commission_wallet->commission_wallet + $commission_amount_actual;

                    CommissionWalletHistory::create($history_data);
                    $commission_wallet->increment('commission_wallet',$commission_amount_actual);

                    $data["status"] = 1;
                    $data["actual_commission_amount"] = $commission_amount;
                    $data["amount"] = $commission_amount_actual;
                    
                    $data["user_id"] = $value->id;
                    $data["from_user_id"] = $stakingpool->user_id;
                    $data["stacking_pool_id"] = $stakingpool->id;
                    $data["description"] = 'Referral commission from '.$stakingpool->user_detail->username;
                    $data["description_cn"] = '直系推荐佣金从 '.$stakingpool->user_detail->username;
                    $data["actual_percent"] = $level_commission_percent;
                    $data["percent"] = $package_detail->direct_refferal;

                    ReferralCommission::create($data);
                    $commission_wallet->increment('referral_commission',$commission_amount_actual);


                }
            }
        });
        
        return Command::SUCCESS;
    }
}
