<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Usernftwallet;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\RankController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\NewsandEventsController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Backend\SliderController;

//     return view('welcome');
// });

Route::get('/admin-portal', function(){
    return redirect()->route('admin.login');
});

Route::group(['middleware' => 'prevent-back-history'],function(){

    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/test-reset-mail', [App\Http\Controllers\Auth\RegisterController::class, 'testResetMail']);

    /*check sponsor username exits*/
    Route::post('/sponsor-username-exits', [App\Http\Controllers\CommonController::class, 'sponsorUsernameExists'])->name('sponsorUsernameExits');
    /**Icnumber duplicatioan check */
    Route::any('ic-number-duplication/', [App\Http\Controllers\CommonController::class, 'icNumberDuplication'])->name('icNumberDuplication');
    Route::any('ic-number-duplication-edit/', [App\Http\Controllers\CommonController::class, 'icNumberDuplicationedit'])->name('icNumberDuplicationedit');
    Route::post('/placement-username-exits', 'App\Http\Controllers\CommonController@placementUsernameExists')->name('placementUsernameExits');
    Route::post('/email-exits', 'App\Http\Controllers\CommonController@emailExists')->name('emailExists');
    Route::post('/username-exits', 'App\Http\Controllers\CommonController@usernameExits')->name('usernameExits');
    Route::get('withdrawl-request/{key}', 'App\Http\Controllers\CommonController@withdrawlRequestVerify')->name('withdrawlRequestVerify');
    Route::get('nft-withdrawl-request/{key}', 'App\Http\Controllers\CommonController@NftWithdrawalRequest')->name('nftwithdrawlRequestVerify');
    Route::get('counter-offer-request/{key}', 'App\Http\Controllers\CommonController@counterofferrequest')->name('user.counterofferrequest');
    Route::get('calculate-pairing-commission', 'App\Http\Controllers\CommonController@pairingCommission')->name('calculate-pairing');
    Route::get('calculate-referral-commission', 'App\Http\Controllers\CommonController@referralCommission')->name('calculate-referral')
    Route::middleware(['auth','verified','Checkuseractive'])->group(function () {

      
        Route::post('/update-profile-image', 'App\Http\Controllers\AccountController@updateImage')->name('updateImage');
        Route::post('/nft-wallet-address-upadte', 'App\Http\Controllers\AccountController@updateNFTWalletAddress')->name('nft-wallet-address-update');
        Route::get('/my_collection', 'App\Http\Controllers\AccountController@my_collection')->name('my_collection');
        // Route::get('/help_support', 'App\Http\Controllers\HomeController@help_support')->name('help_support');
        Route::get('/sell_nft', 'App\Http\Controllers\AccountController@sell_nft')->name('sell_nft');
        Route::get('/viewnftsell/{id}', 'App\Http\Controllers\AccountController@viewNFTSell')->name('view.nftsell');
        Route::get('/viewcounteroffer/{id}', 'App\Http\Controllers\AccountController@viewcounteroffer')->name('nft.viewcounteroffer');
        Route::post('/saleproduct', 'App\Http\Controllers\AccountController@salenftproduct')->name('saleproduct');
        Route::post('/counterofferstatus', 'App\Http\Controllers\AccountController@counterofferstatus')->name('counterofferstatus');
        Route::get('/withdrawal', 'App\Http\Controllers\WithdrawalController@index')->name('withdrawal');
        Route::post('/withdrawal-request', 'App\Http\Controllers\WithdrawalController@withdrawalRequest')->name('withdrawal-request');
        Route::any('resend-email/{id}', 'App\Http\Controllers\WithdrawalController@resendEmail')->name('resendEmail');
        Route::any('nft-resend-email/{id}', 'App\Http\Controllers\NftWalletController@nftresendEmail')->name('nftresendEmail');
       


        Route::get('/faq', 'App\Http\Controllers\HomeController@helpandfaq')->name('helpandfaq');
        // Route::resource('help-support', 'App\Http\Controllers\SupportTicketController')->name('help-support');
        Route::resource('help_support', SupportTicketController::class);
        Route::get('help-support-replay/{id}', [SupportTicketController::class, 'supportReplay'])->name('supportReplay');
        Route::get('help-support-close/{slug}', [SupportTicketController::class, 'supportClose'])->name('supportClose');
        Route::post('help-support-replay-message', [SupportTicketController::class, 'supportReplayPost'])->name('supportReplayPost');

        Route::get('/stacks', 'App\Http\Controllers\StackingPoolController@index')->name('stacks');
        Route::post('/stacking-pool', 'App\Http\Controllers\StackingPoolController@stacking_pool')->name('staking_pool');
        Route::get('/stack/{id}', 'App\Http\Controllers\StackingPoolController@detail')->name('stakepool');
        Route::get('staking-pool/investmentperiod/{id}', 'App\Http\Controllers\StackingPoolController@investmentperiod')->name('stock-market-investment-period');
        Route::post('/stake-plan-change/{id}', 'App\Http\Controllers\StackingPoolController@changePlan')->name('stake-plan-change');
        Route::middleware(['checkUserStaking'])->group(function () {
            Route::resource('news-and-events', NewsandEventsController::class);

            Route::get('/node_management', 'App\Http\Controllers\AccountController@node_management')->name('node_management');

        });
    });


    //Admin
Route::prefix('admin-portal')->group(function () {

    Route::get('login', [App\Http\Controllers\Backend\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Backend\AdminLoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Backend\AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('admin.dashboard');
            // User Crud
        Route::resource('user', UserController::class);

        Route::prefix('user')->group(function () {
                 // Crypto wallet
          Route::resource('crypto-wallet-history', Usercryptowallet::class);
               // nft wallet
          Route::resource('nft-wallet-history', Usernftwallet::class);
               // yield wallet
          Route::resource('yield-wallet-history', UseryieldwalletController::class);
                //Commission wallet
          Route::resource('commission-wallet-history', UsercommissionwalletController::class);
      });
            // News Crud
        Route::resource('news', NewsController::class);

            // Slider
        Route::resource('slider', SliderController::class);


            // Support Ticket
        Route::get('support-ticket/{slug}', [AdminSupportController::class, 'index1'])->name('support_ticket.index1');
        Route::resource('support_ticket', AdminSupportController::class);


            // Rank-setting
        Route::resource('rank_setting', RankController::class);

            // General Setting
        Route::resource('setting', SettingController::class);

            // Withdrawal Request 
        Route::resource('withdrawal_request', AdminWithdrawalRequest::class);
        Route::post('bankproof',  [AdminWithdrawalRequest::class, 'bank_proofs'])->name('user.bank_proofs');
        Route::any('withdrawal-request-export',[AdminWithdrawalRequest::class, 'exportData'])->name('withdrawal_request.export');

        Route::resource('nft_withdrawal_request', AdminNftWithdrawalRequest::class);
        Route::post('nft/bankproof',  [AdminNftWithdrawalRequest::class, 'bank_proofs'])->name('nft_withdrawal_request.bank_proofs');
        Route::any('nft/withdrawal-request-export',[AdminNftWithdrawalRequest::class, 'exportData'])->name('nft_withdrawal_request.export');
            // package crud
        Route::resource('packages', PackageController::class);
        Route::resource('pool-packages', PoolPackageController::class);
            // NFT Category
        Route::resource('nft-category', NFTCategoryController::class);
            // NFT Product
        Route::resource('nft-product', NFTProductController::class);
             // NFT Product TradingHistoryController
        Route::resource('trading-history', TradingHistoryController::class);

            // Yield Wallet History
        Route::resource('yield_wallet', YieldWalletController::class);
        Route::any('yield-wallet-history-export',[YieldWalletController::class, 'exportData'])->name('yield-wallet-history-export.export');

            // Stacking Pool History
        Route::resource('stacking_pool_history', StackingpoolhistoryController::class);
        Route::any('stacking-pool-history-export',[StackingpoolhistoryController::class, 'exportData'])->name('stacking_pool_history.export');

            // Referral commissions
        Route::resource('referral_commission', ReferralcommissionsController::class);         

            // Crypto Wallets Payment History
        Route::resource('crypto_wallets_payment_history', CryptoWalletsPaymentController::class);
        Route::any('crypto_wallets_payment_history_export',[CryptoWalletsPaymentController::class, 'exportData'])->name('crypto_wallets_payment_history.export');

            // Crypto Wallets USDT Credit Requests Approve or Reject.
        Route::resource('crypto_wallets_credit_request', CryptocreditrequestController::class);
        Route::any('crypto_wallets_credit_request_export',[CryptocreditrequestController::class, 'exportData'])->name('crypto_wallets_credit_request.export');

            // Nft Wallets Payment History
        Route::resource('nft_wallets_payment_history', NftWalletsPaymentController::class);
        Route::any('nft_wallets_payment_history_export',[NftWalletsPaymentController::class, 'exportData'])->name('nft_wallets_payment_history.export');

            // Nft Wallets USDT Credit Requests Approve or Reject.
        Route::resource('nft_wallets_credit_request', NftcreditrequestController::class);
        Route::any('nft_wallets_credit_request_export',[NftcreditrequestController::class, 'exportData'])->name('nft_wallets_credit_request.export');

            // NFT Purchase History
        Route::resource('nft_purchase_history', NftpurchaseController::class);
        Route::any('nft_purchase_history_export',[NftpurchaseController::class, 'exportData'])->name('nft_purchase_history.export');


            // NFT Purchase Requests
        Route::resource('nft_purchase_request', NftpurchaserequestController::class);
        Route::any('nft_purchase_request_export',[NftpurchaserequestController::class, 'exportData'])->name('nft_purchase_request.export');

            //Stacking Pools Coin
        Route::resource('stacking-pools-coin', StackingpoolscoinController::class);

            //usdt Address
        Route::resource('usdt_address', UsdtAddressController::class);


        //NFT On sale Request
        Route::resource('nft_on_sale_request', NftOnsaleController::class);
    });
});











});