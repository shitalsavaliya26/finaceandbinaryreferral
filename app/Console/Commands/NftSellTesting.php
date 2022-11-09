<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\NftProduct;
use App\Models\UserWallet;
use App\Models\NftPurchaseLog;
use App\Models\NftSellHistory;
use Illuminate\Console\Command;
use App\Models\NftPurchaseHistory;
// use App\Models\NftReservedProduct;
use App\Models as Model;

class NftSellTesting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'nftproduct:selltesting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sell Nft Product';

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
        $date = Carbon::today()->format('Y-m-d');
        $changestatus = NftSellHistory::where('status','5')->whereNotNull('approve_for_processing_date')->whereDate('approve_for_processing_date','<=',$date)->get();
        
        foreach ($changestatus as $change) {

            $purchasechangestatus = NftPurchaseHistory::find($change->nft_purchase_history_id);
            $purchasechangestatus->status = 3;
            $purchasechangestatus->sell_date = Carbon::now();
            $purchasechangestatus->save();


            $userwallet = UserWallet::where('user_id',$change->user_id)->first();
            // $userwallet->increment('nft_wallet',$change->sale_amount);

            
            $Nftpurchaselog = NftPurchaseLog::create([
                'purchase_user_type' => "admin",
                'product_id' => $change->product_id,
                'purchase_amount' => $change->sale_amount,
            ]);

            $nftproduct = NftProduct::find($change->product_id);
            $nftproduct->product_status = 'Hidden';
            $nftproduct->is_reserved = 0;
            $nftproduct->save();


            // $product = NftReservedProduct::where('product_id',$change->product_id)->first();
            // $product->delete();

            $withdrawal = new Model\WithdrawalWalletHistory;
            $withdrawal->user_id = $purchasechangestatus->user_id;
            $withdrawal->amount = $change->sale_amount;
            $withdrawal->description = 'NFT '.$nftproduct->name.' Sold';
            $withdrawal->type = '1';
            $withdrawal->save();
            Model\UserWallet::where('user_id',$purchasechangestatus->user_id)->increment('withdrawal_balance',round($change->sale_amount,2));

            $change->status = 7;
            $change->save();
        }
        $this->info('Successfully NFT Product Sell.');
        // return Command::SUCCESS;
    }
}
