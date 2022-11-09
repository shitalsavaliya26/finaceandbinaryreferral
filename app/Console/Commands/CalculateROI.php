<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StackingPool;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\UserWallet;
use App\Models\Package;
use App\Models\NftWalletHistory;
use App\Models\YieldWalletHistory;

class CalculateROI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:monthlyROI {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate User ROI monthly.';

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
            $result_date = ($this->argument('date')) ? Carbon::createFromFormat('Y-m-d H:i:s', $this->argument('date').' 00:00:00')->subDay()->format('Y-m-d') : Carbon::today()->subDay()->format('Y-m-d');

            
            $stakingpools = StackingPool::where('status',1)->get();
            foreach($stakingpools as $stakingpool){
                $staking_pool_package = $stakingpool->staking_pool_package;
                $package_detail = Package::where('amount','<=',$stakingpool->amount)->orderBy('amount','desc')->first();
                if(!$package_detail){
                    continue;
                }
                $apypercent = 0;
                if($stakingpool->staking_period == 24){
                    $apypercent = $this->rand_float($package_detail->stacking_actual24_start,$package_detail->stacking_actual24_end);
                    $roi = $stakingpool->amount * ($apypercent / 100);
                }else{
                    $apypercent = $this->rand_float($package_detail->stacking_actual12_start,$package_detail->stacking_actual12_end);
                    $roi = $stakingpool->amount * ($apypercent / 100);
                }
                $commission_wallet = UserWallet::where('user_id',$stakingpool->user_id)->first();

                $nft_commission = Setting::where('key','nft_commission')->value('value');
                $nft_commission = ($nft_commission > 0) ? $nft_commission/100 : 0.2; 
                $nft_commission_amount = $roi * $nft_commission;
                $roiamount = $roi - $nft_commission_amount;

                $history_data["type"] = "1";
                $history_data["amount"]  = $nft_commission_amount;
                $history_data["user_id"] = $stakingpool->user_id;
                $history_data["description"]  = 'ROI';
                $history_data["final_amount"] = $commission_wallet->nft_wallet + $nft_commission_amount;

                NftWalletHistory::create($history_data);
                $commission_wallet->increment('nft_wallet',$nft_commission_amount);

                $data["user_id"] = $stakingpool->user_id;
                $data["actual_commission_amount"] = $roi;
                $data["amount"] = $roiamount;
                $data["type"] = '1';

                $data["stacking_pool_id"] = $stakingpool->id;
                $data["description"] = 'ROI';
                $data["percent"] = $apypercent;

                YieldWalletHistory::create($data);
                $commission_wallet->increment('yield_wallet',$roiamount);
                $commission_wallet->increment('roi',$roiamount);

            }
        });
        return Command::SUCCESS;
    }

    function rand_float($st_num=0,$end_num=1,$mul=1000000)
    {
        if ($st_num>$end_num) return false;
        return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
    }
}
