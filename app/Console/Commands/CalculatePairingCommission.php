<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PairingCommission;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Package;
use App\Models\CommissionWalletHistory;
use App\Models\UserWallet;
use App\Models\Setting;
use App\Models\NftWalletHistory;
use App\Models\StackingPool;

class CalculatePairingCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:pairingcommission {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate users pairing referral commission';

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
        $users = User::where('status','active')->whereHas('placementLeft')->whereHas('placementRight')->orderBy('id','asc')->get();
        $result_date = ($this->argument('date')) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->argument('date').' 00:00:00')->format('Y-m-d') : Carbon::today()->format('Y-m-d');
        foreach($users as $user){

            /* testing purpose */
            // StackingPool::where(["user_id" => $user->id])->whereDate('created_at',$result_date)->delete();
            // PairingCommission::where(["user_id" => $user->id])->whereDate('created_at',$result_date)->delete();
            // NftWalletHistory::where(["user_id" => $user->id,'description' => 'Pairing commission'])->whereDate('created_at',$result_date)->delete();
            // CommissionWalletHistory::where(["user_id" => $user->id,'description' => 'Pairing commission'])->whereDate('created_at',$result_date)->delete();

            // $todaysPool = PairingCommission::where(["user_id" => $user->id])->whereDate('created_at',$result_date)->count();

            // if($todaysPool > 0){
            //     continue;
            // }

            $leftDownlineGroupsaleActual  = $leftDownlineGroupsale  = Helper::getTotalgroupsalesTodayLeft($user); 
            $rightDownlineGroupsaleActual = $rightDownlineGroupsale = Helper::getTotalgroupsalesTodayRight($user);
            // if($leftDownlineGroupsaleActual == 0 && $rightDownlineGroupsaleActual == 0){
            //     continue;
            // }
            $cf = $user->userwallet->carry_forward;
            $carry_forward_to = 0;
            if($user->userwallet->carry_forward_to == 'left'){
                $leftDownlineGroupsale += $cf;
            }
            if($user->userwallet->carry_forward_to == 'right'){
                $rightDownlineGroupsale += $cf;
            }
            if($leftDownlineGroupsale == 0 && $rightDownlineGroupsale == 0){
                continue;
            }

            $packageamount  = $user->userwallet->stacking_pool;
            $package_detail = Package::where('amount','<=',$packageamount)->orderBy('amount','desc')->first();
            if(!$package_detail){
                continue;
            }

            /* daily limit */
            $daily_limit = ($package_detail) ? $package_detail->daily_limit : 100;

            /* pairing value */
            $pairing_value = ($package_detail) ? $package_detail->network_pairing : 10;

            if($leftDownlineGroupsale < $rightDownlineGroupsale && $leftDownlineGroupsale != 0){
                $groupsale = $leftDownlineGroupsale;
                $carry_forward = $rightDownlineGroupsale - $leftDownlineGroupsale;
                $pairing_got_from = 'left';
            }else{
                $groupsale = $rightDownlineGroupsale;
                $carry_forward = $leftDownlineGroupsale - $rightDownlineGroupsale;
                $pairing_got_from = 'right';
            }
            if($rightDownlineGroupsale == 0){
                $groupsale = $leftDownlineGroupsale;
                $carry_forward = $leftDownlineGroupsale;
                $pairing_got_from = 'right';
            }
            if($leftDownlineGroupsale == 0){
                $groupsale = $rightDownlineGroupsale;
                $carry_forward = $rightDownlineGroupsale;
                $pairing_got_from = 'left';
            }
            $carry_forward_to = ($carry_forward > 0) ? (($pairing_got_from == 'left') ? 'right' : 'left') : null;

            // echo $carry_forward_to.'--'; echo $rightDownlineGroupsale;
            // die();
            if($leftDownlineGroupsale == 0 || $rightDownlineGroupsale == 0){
                $carry_forward_to = ($carry_forward > 0) ? (($pairing_got_from == 'left') ? 'right' : 'left') : null;
                $user->userwallet->carry_forward = $carry_forward;

                $user->userwallet->carry_forward_to = $carry_forward_to;
                $user->userwallet->save();
                continue;
            }


            $pairing_commission = ($groupsale * $pairing_value) / 100;
            $pairing_commission = ($pairing_commission > $daily_limit) ? $daily_limit : $pairing_commission;

            $user->userwallet->pairing_commission = $user->userwallet->pairing_commission + $pairing_commission;
            $user->userwallet->carry_forward = $carry_forward;
            $user->userwallet->carry_forward_to = $carry_forward_to;
            $user->userwallet->save();

            if($pairing_commission > 0){
                $commission_wallet = UserWallet::where('user_id',$user->id)->first();
                $nft_commission = Setting::where('key','nft_commission')->value('value');
                $nft_commission = ($nft_commission > 0) ? $nft_commission/100 : 0.2; 
                $nft_commission_amount = $pairing_commission * $nft_commission;
                $pairing_commission_amount = $pairing_commission - $nft_commission_amount;
                $history_data["type"] = "1";
                $history_data["amount"] = $nft_commission_amount;
                $history_data["user_id"] = $user->id;
                $history_data["description"] = 'Nodes Balancing Commission';
                $history_data["description_cn"] = '节点平衡佣金';
                $history_data["final_amount"] = $commission_wallet->nft_wallet + $nft_commission_amount;

                NftWalletHistory::create($history_data);
                $commission_wallet->increment('nft_wallet',$nft_commission_amount);
                
                $commission_wallet->increment('pairing_commission',$pairing_commission_amount);
                PairingCommission::create(['user_id' => $user->id,
                    'left_sale' => $leftDownlineGroupsaleActual,
                    'right_sale' => $rightDownlineGroupsaleActual,
                    'carry_forward_used' => $cf,
                    'carry_forward' => $carry_forward,
                    'actual_amount' => $groupsale,
                    'actual_commission_amount' => $pairing_commission,
                    'commission_got_from' => $pairing_got_from,
                    'pairing_percent' => $pairing_value,
                    'pairing_commission' => $pairing_commission_amount,
                    'daily_limit' => $daily_limit
                ]) ;

                $history_data["type"] = "1";
                $history_data["amount"] = $pairing_commission_amount;
                $history_data["user_id"] = $user->id;
                $history_data["from_user_id"] = $user->id;
                $history_data["commission_type"] = 'pairing';
                $history_data["description"] = 'Nodes Balancing Commission';
                $history_data["description_cn"] = '节点平衡佣金';
                $history_data["final_amount"] = $commission_wallet->commission_wallet + $pairing_commission;

                CommissionWalletHistory::create($history_data);
                $commission_wallet->increment('commission_wallet',$pairing_commission_amount);
                /* testing purpose */

            }
        }
        // StackingPool::whereDate('created_at',$result_date)->delete();
        return Command::SUCCESS;
    }
}
