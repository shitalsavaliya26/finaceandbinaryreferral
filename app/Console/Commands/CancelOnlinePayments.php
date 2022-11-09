<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models as Model;
use App\Helpers\Helper;
use Carbon\Carbon;

class CancelOnlinePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:online_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel all cryptowallet payments after 10 mins';

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
        $fund_wallet=Model\CryptoWallet::whereIn('type',['1','2'])->whereIn('status',['0'])->get();
        foreach ($fund_wallet as $key => $value) {
          $log_data['data'] = $value;
          try {
            $now=Carbon::now();
            $hours=$now->diff($value->created_at)->format('%I');
            echo "<br>Today Date::".$now;
            echo "<br>#ID::".$value->id;
            echo "<br>UserId::".$value->user_id;
            echo "<br>UserId::".$value->user_detail->username;
            echo "<br>Name::".$value->user_detail->name;
            echo "<br>Hours::".$hours;
            echo "<br>Created Date::".$value->created_at;

            if($hours >= 10){
                $value->status='2';
                $value->action_date = Carbon::now();
                $value->remark='Online Payment Transaction cancelled.';
                $value->save();
            }

        } catch (Exception $e) {

            continue;
        }
        // Helper::createAdminLog($this->path,'cancel_online_payment_'.date('Y-m-d').'.log',"_ERROR_LOG_",$log_data);

    } 
    return Command::SUCCESS;
}
}
