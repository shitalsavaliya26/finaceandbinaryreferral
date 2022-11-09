<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StackingPoolCoin;

class UpdateCoinPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:stakingpoolcoinsprice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stacking pool coin prices';

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
        $coins = StackingPoolCoin::all();
        foreach($coins as $coin){
            if($coin->chain != ''){

                $curl = curl_init();
                $url = "https://api.coingecko.com/api/v3/simple/price?ids=".$coin->chain."&vs_currencies=usd";
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "cache-control: no-cache",
                ),
              ));
                
                // $url = "https://deep-index.moralis.io/api/v2/erc20/".$coin->address."/price?chain=".$coin->chain;
                // // echo $url;die();
                // curl_setopt_array($curl, array(
                //   CURLOPT_URL => $url,
                //   CURLOPT_RETURNTRANSFER => true,
                //   CURLOPT_ENCODING => "",
                //   CURLOPT_MAXREDIRS => 10,
                //   CURLOPT_TIMEOUT => 30,
                //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //   CURLOPT_CUSTOMREQUEST => "GET",
                //   CURLOPT_HTTPHEADER => array(
                //     "accept: application/json",
                //     "cache-control: no-cache",
                //     "x-api-key: V7Z416XXnWUwvhQAgwgPWbo8H4aKyhfliI6ZzHyN8WSde5KAF3voskuzIFmQxNbp"
                //   ),
                // ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                \Log::channel('fundlog')->info('Response: '.$response);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;

                    $result = json_decode($response,true);
                    print_r($result);
                    $usdValue = $result[$coin->chain];
                    $coin->price = $usdValue['usd'];
                    $coin->save();

                }
            }
        }
        return Command::SUCCESS;
    }
}
