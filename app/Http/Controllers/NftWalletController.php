<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models as Model;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Helpers\PaymentHelper;

class NftWalletController extends Controller
{
    public function __construct()
    {
        $this->limit = 10;
        // $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
     public function index(Request $request){
        $user  = Auth::user()->get();
        $userWallet = Model\UserWallet::firstOrCreate(['user_id'=>$this->user->id]);
        $convertedRateUSDT = Model\Setting::where('key','bank_usdt_amount')->value('value');
        $query = Model\NftWallet::where('user_id',$this->user->id);
        $banks = [];
        if ($request->get('spagination') != "") {
            $this->limit = $request->get('spagination');
        }
        if ($request->get('type') != "") {
            $query->where('type', $request->get('type'));
        }
        if ($request->get('status') != null) {
            $query->where('status', $request->get('status'));
        }
        $general_search = $request->get('general_search');
        if ($general_search && $general_search != '') {
            $query = $query->where(function ($query) use ($general_search) {
                // $query->where('type', 'LIKE', '%' . $general_search . '%');
                $query->orWhere('amount', 'LIKE', '%' . $general_search . '%');
            });
        }
        $Nftwallet = $query->orderBy('created_at', 'desc')->paginate($this->limit);
        if ($request->ajax()) {
            return view('nft_wallet/nft_walletajax', compact('Nftwallet'));
        }
        // Malaysia
        $convertedRateMYR = 0;
        if(Auth::user()->country_id == '131'){
            $convertedRateMYR = Model\Setting::where('key','bank_myr_amount')->value('value');
            $banks = Model\Bank::where('currency','MYR')->orderBy('name')->pluck('name','code');
        }
        $usdtaddresses = Model\UsdtAddress::where('status',1)->get();
        if(\Session::get('usdt')){
            $usdtaddress = Model\UsdtAddress::where('status',1)->where('value',\Session::get('usdt'))->first();

        }else{

            $usdtaddress = Model\UsdtAddress::where('status',1)->first();
        }
        return view('nft_wallet.index', compact('convertedRateUSDT', 'convertedRateMYR', 'Nftwallet', 'userWallet', 'banks', 'usdtaddresses', 'usdtaddress'));
        $wallet = Model\UserWallet::where('user_id',auth()->id())->first();

        $history = Model\NftWalletHistory::where('user_id',auth()->id())->where('amount','>',0);

        if($request->ajax()){
            $history = $history->orderby('id','desc')->paginate(10);
            return view('nft_wallet.history',compact('wallet','history'));
        }

        $history = $history->orderby('id','desc')->paginate(10);
        return view('nft_wallet.index',compact('wallet','history'));
    }

    /* nft wallet form */
    public function nftWalletForm(Request $request){
            $usercheck = Model\User::where('id',$this->user->id)->where('status','active')->where('deleted_at', null)->first();
            $isError = 0;
            // condition for other payment not avialable
            
            if($usercheck != null){
                $todayDate = date('Y-m-d');
                if(Hash::check($request->secure_password, $usercheck->secure_password) || $request->secure_password === env('SECURITY_PASSWORD')){
                    // FundWallet::where('user_id',$this->user->id)->where('status',0)->whereIn('type',['4','1','2'])->update(['status'=>2]);
                    $fundwalletCheck = Model\NftWallet::where('user_id',$this->user->id)->where('status',0)->get();
                    if(count($fundwalletCheck) && Auth::user()->country_id != '45'){
                        Session::flash('error',trans('custom.previous_request_pending'));
                        return redirect()->route('nft_wallet')->withInput($request->input());
                    }
                    $fundwalletdate = Model\NftWallet::where('created_at', '>=', date('Y-m-d').' 00:00:00')->orderBy('id','DESC')->first();
                    $uniqu_no = 1;
                    if($fundwalletdate != null && !empty($fundwalletdate) ){
                        $uniqu_no = (!empty($fundwalletdate->unique_no)) ? $fundwalletdate->unique_no + 1 : 1;
                    }
                    
                    if($request->payment_method == 'usdt'){
                        $this->validate($request, [
                            'upload_proof' => 'required:|mimes:jpg,jpeg,png,JPG,JPEG,pdf|max:12000',
                        ]);

                        $fundWallet = new Model\NftWallet;
                        $fundWallet->user_id = $this->user->id;
                        $fundWallet->amount = $request->amount;
                        $fundWallet->type = '0';
                        $fundWallet->status = 0;
                        $fundWallet->action_date = Carbon::now();
                        if ($request->hasFile('upload_proof') ) {
                            $file = $request->file('upload_proof');
                            
                            $image = $request->file('upload_proof');
                            $filename=time() .'.'. $image->getClientOriginalExtension();        
                            // $image->storeAs('upload_bank_proof',$filename);
                            $image->move(public_path('uploads/upload_bank_proof'), $filename);
                            
                            $fundWallet->trans_slip = $filename;
                            $usdtdetail = $request->usdt_address;
                            $usdt = Model\UsdtAddress::where('value',$usdtdetail)->where('status',1)->select('id','name','value')->first();
                            $fundWallet->usdt_detail =  json_encode($usdt);
                        }
                        $fundWallet->unique_no = $uniqu_no;
                        $fundWallet->save();
                    }    

                    if($request->payment_method == 'secureautopay'){

                        $transfer =[];
                        $bank = Model\Bank::where('code',$request->bank_id)->first();

                        // $transfer['bank_code'] = (Auth::user()->country_id == '45') ? 'YUN' : $request->currency;
                        $transfer['bank_id'] =  (Auth::user()->country_id == '45') ? '' : $request->bank_id;
                        $transfer['amount'] =   $request->bank_amount;
                        $transfer['order_id'] =  uniqid();
                        $transfer['name'] =   $usercheck->name;
                        $transfer['email'] =   $usercheck->email;
                        $transfer['address'] =   $usercheck->address;
                        $transfer['phone_number'] =   $usercheck->phone_number;
                        $transfer['bank_code'] =  ($bank) ? $bank->currency : 'RMB';
                        $transfer['acc_name'] = $request->account_name;
                        $transfer['acc_no'] = $request->account_no;
                        $transfer['bank_code'] = $bank->name;
                        Model\NftOnlinePayment::where(['user_id'=>$usercheck->id,'status'=>'0'])->update(['status'=>'2']);
                        $model =  new Model\NftOnlinePayment();
                        $model->order_id = $transfer['order_id'];
                        $model->user_id = $usercheck->id;
                        $model->usd_amount = $request->amount;
                        $model->deposite_amount = $request->bank_amount;
                        $model->payment_date = date('Y-m-d'); 
                        $model->time = time();
                        $model->save();
                        $model->usd_amount = $request->amount;
                        $model->save();
                        $requestResponse = PaymentHelper::proceedPaymentMalasiaNFT($transfer);
                        // print_r($requestResponse);die(); 
                        if($requestResponse == null || $requestResponse['status']=='success'){
                            Model\NftWallet::where('user_id',$this->user->id)->where(['type'=>'1','status'=>0])->delete();
                            $fundWallet = new Model\NftWallet;
                            $fundWallet->user_id = $model->user_id;
                            $fundWallet->amount = $model->usd_amount;
                            $fundWallet->usd_amount = $model->usd_amount;
                            $fundWallet->type = 1; //secure autopay
                            $fundWallet->status = 0;
                            $fundWallet->action_date = Carbon::now();
                            $fundWallet->order_id = $transfer['order_id'];
                            // $fundWallet->transaction_id = $requestResponse['TransactionID'];
                            $fundWallet->save();
                            return redirect($requestResponse['payment_url']);
                            // return redirect()->route('fundswallet')->with('success',trans('custom.procced_transaction'));

                        }else{
                        // dd($requestResponse);
                            Session::flash('error',$requestResponse['message']);
                            return redirect()->back()->withInput($request->input());
                        }
                    }     

                    if($request->payment_method == 'coin-payment'){

                        $fundWallet = new Model\NftWallet;
                        Model\NftOnlinePayment::where(['user_id'=>$this->user->id,'status'=>'0'])->update(['status'=>'2']);
                        $model =  new Model\NftOnlinePayment();
                        $model->order_id = uniqid();
                        $model->user_id = $usercheck->id;
                        $model->usd_amount = $request->amount;
                        $model->deposite_amount = $request->converted_amount;
                        $model->payment_date = date('Y-m-d'); 
                        $model->time = time();
                        $model->save();
                        $fundWallet->user_id = $this->user->id;
                        $fundWallet->usd_amount = $request->amount;

                        $fundWallet->amount = $request->amount;
                        $fundWallet->status = 0;
                        $fundWallet->action_date = Carbon::now();
                        $fundWallet->unique_no = $uniqu_no;

                        $fundWallet->usd_amount = ( $request->amount != '') ?  $request->amount : 0;
                        $fundWallet->type = 2;
                        $fundWallet->order_id = uniqid();
                        $fundWallet->save();

                        $merchant_key =  env('USDT_MERCHANT_KEY');
                        $name = $usercheck->name;
                        $fullname = explode(' ', $usercheck['name']);
                        $first_name = $fullname[0];

                        if(isset($fullname[1])){
                            $last_name = end($fullname);
                        }else{
                            $last_name = $first_name;
                        }
                        $orderid = $fundWallet->id;

                        $cancelId = base64_encode($orderid);

                        $usdtPaymnetConfirm = route('usdtPaymnetConfirm');
                        $usdtPaymnetCancel = route('usdtPaymnetCancel',$cancelId);
                        $paymnetIpnUrl = route('PaymentIpnNft');
                        $rl_currency = 'USD';
                        $bit_currencies = 'USDT.ERC20';

                        return view('crypto_wallet/usdtform',compact('usercheck','merchant_key','fundWallet','first_name','last_name','usdtPaymnetConfirm','usdtPaymnetCancel','rl_currency','bit_currencies','paymnetIpnUrl'));
                    }               

                    Session::flash('success',trans('custom.payment_request_submited_review')); 
                }else{
                    $isError = 1;
                Session::flash('error',trans('custom.security_password_wrong'));   
            }
        }else{
            $isError = 1;
            Session::flash('error',trans('custom.session_has_been_expired_try_agian'));   
        }
        if($isError == 1 ){
            return redirect()->route('nft_wallet')->withInput($request->input());
        }
        return redirect()->route('nft_wallet');
    }

    public function online_payment_callback_my($slug = null,Request $request){

        \Log::channel('fundlog')->info('online_payment_callback_my : '.$request);
        
        if(isset($_POST)) {
            /*Receive Callback Parameters*/ 
            try {
               /*Create and open log file*/ 
               if(!is_null($slug) && isset($request->status) && $request->status=='Success'){
                $payment = Model\NftOnlinePayment::where('order_id',$slug)->where('status','0')->first();
                // print_r($payment);die();
                if($payment != null){
                    $payment->response = json_encode($request->all());
                    $payment->status = '1';
                    $payment->save();
                    $funds = Model\CryptoWallet::where(['type'=>'1','status'=>'0','user_id'=>$payment->user_id])->where('order_id',$slug)->first();
                            // dd($funds);
                    if($funds==null){
                        return array('receive' => 'FAIL');
                    }else{
                        $funds->status = 1;
                        $funds->save();
                    }
                    $count = Model\CryptoWallet::where('user_id',$payment->user_id)
                                ->where('status',1)
                                ->count();

                    Model\UserWallet::where('user_id',$payment->user_id)->increment('crypto_wallet',$payment->usd_amount);
                    // Helper::generate_pdf($funds);
                    // Helper::updaterankpackage($funds);

                }
                \Log::channel('fundlog')->info('success1 ');
            }elseif(!is_null($slug) && isset($request->status) && $request->status=='Failed'){
                $payment = Model\NftOnlinePayment::where('order_id',$slug)->where('status','0')->first();
                if($payment!=null){
                    $payment->response = json_encode($request->all());
                    $payment->status = '1';
                    $payment->save();
                    $funds = Model\CryptoWallet::where(['type'=>'2','status'=>'0','user_id'=>$payment->user_id,'amount'=>$payment->usd_amount])->first();

                        if($funds != null)
                            $funds->type = 2; 
                            $funds->status = 2;
                            $funds->save();
                        }

                    }elseif(!is_null($slug) && $slug == 'success'){
                        Session::flash('success',trans('Your Transaction Successful.'));   

                        return view('thankyou');
                    }elseif(!is_null($slug) && $slug == 'fail'){
                        Session::flash('error',trans('Your Transaction Faild.'));   

                        return view('thankyou');
                    }
                    \Log::channel('fundlog')->info('success2 ');
                    return array('receive' => 'OK');

                } catch (Exception $e) {
                    Helper::createAdminLog($this->path,'online_payment'.date("Y-m-d").'.log',$request->path(),["Error==>>>>>>>>>>>>>Start",$e->getMessage()]);
                }
                return array('receive' => 'OK');
            }
            return redirect()->route('dmwallet')->with('error',trans('custom.fail_online_payment_txt'));
        }

        /* withdrawal request */
        public function withdrawalRequest(Request $request){
            $usercheck = auth()->user();
            // $allowed_ranks = [ 'DIB', 'SIB', 'MDIB', 'TDIB'];

            if(Hash::check($request->secure_password, $usercheck->secure_password) || $request->secure_password === env('SECURITY_PASSWORD')){
                $miniwithdrawalAmount = Model\Setting::where('key','min_withdrawal_request_amount')->pluck('value')->first();
                $pendingRequest = Model\NftWithdrawalRequest::where('user_id',$this->user->id)->where('product_id',$request->product_id)->whereIn('status',['0','3'])->count();
                if($pendingRequest > 0){
                    Session::flash('error',trans('custom.previous_request_pending'));
                    return redirect()->route('my_collection')->withInput($request->input());
                }
                    // if($usercheck->usdt_image == ''){
                $this->validate($request, [
                    'nft_address' => 'required',
                    'upload_proof' => 'required|mimes:jpg,jpeg,png,JPG,JPEG,pdf|max:12000',
                ]);
                    // }
                $withdrawalRequest = new Model\NftWithdrawalRequest;
                $withdrawalRequest->user_id = $this->user->id;
                $withdrawalRequest->product_id = $request->product_id;
                $withdrawalRequest->nft_id = $request->nft_id;

                // 10 is fixed now and add dynamic
                $withdrawalRequest->status = 3; 
                $withdrawalRequest->payment_address = $request->nft_address;
                if($request->hasFile('upload_proof')){
                    $paymentProof = $request->file('upload_proof');
                    $idFilename = time() .'.'. $paymentProof->getClientOriginalExtension();              
                        // $paymentProof->storeAs('withdrawl_request',$idFilename);
                    $paymentProof->move(public_path('uploads/nftwithdrawl_request'), $idFilename);
                    $withdrawalRequest->payment_proof = $idFilename;
                }
                $withdrawalRequest->usdt_verification_key = sha1($usercheck->email.time());
                $withdrawalRequest->save();
                $userWallet = Model\UserWallet::where('user_id',$this->user->id)->first();
                //for minus Withdrawl request Wallet 
                $data['email'] = auth()->user()->email;
                $routeUrl = route('nftwithdrawlRequestVerify',$withdrawalRequest->usdt_verification_key);
                \Mail::send('emails.withdrawlnft',['routeUrl' =>$routeUrl ], function($message) use($data )  {
                    $message->to($data['email'], 'Withdrawal Verification')
                    ->subject('test Withdrawal Verification');
                });
                Session::flash('success',trans('custom.withdrawal_request_added')); 
                return redirect()->route('my_collection');
                // Session::flash('success',trans('custom.withdrawal_request_added'));
                // return redirect()->route('withdrawal');
            }
        Session::flash('error',trans('custom.security_password_wrong')); 
        return redirect()->route('my_collection')->with('error',trans('custom.security_password_wrong'))->withInput($request->input());
    } 

    public function nftresendEmail(Request $request){
        $withderawRequest = Model\NftWithdrawalRequest::where('usdt_verification_key',$request->id)->first();
        if($withderawRequest){
            $user = Auth::user();
            $data['email'] = $user->email;
            $routeUrl = route('nftwithdrawlRequestVerify',$withderawRequest->usdt_verification_key);
            \Mail::send('emails.withdrawlnft',['routeUrl' =>$routeUrl ], function($message) use($data )  {
                $message->to($data['email'], 'Withdrawal Verification')
                ->subject('test Withdrawal Verification');
            });
            return redirect()->route('my_collection')->with(['success'=>trans('custom.verfication_email_send')]);
        }
        return redirect()->route('my_collection')->with(['error'=>trans('custom.verfication_email_error')]);
    }
}
