<?php

namespace App\Http\Controllers;

use DB,Session;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Country;
use App\Models\Package;
use App\Models\Setting;
use App\Models\UserBank;
use Carbon\CarbonPeriod;
use App\Models\User,Auth;
use App\Models\NftProduct;
use App\Models\UserWallet;
use App\Models\StackingPool;
use Illuminate\Http\Request;
use App\Models\UserAgreement;
use App\Models\PairingCommission;
use App\Models\NftPurchaseHistory;
use App\Models\StackingPoolPackage;
use App\Models\NftSellHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models as Model;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /* add member view */
    public function addmember(Request $request){
        $userName = auth()->user()->username;
        $country  = Country::pluck('country_name','id')->toArray();
        $placement = '';
        if($request->get('placement')){
            $placement = $request->get('placement');
        }

        return view('accounts.register',compact('userName','country','placement'));
    }

    /* validate user */
    protected function validator(array $data)
    {
        $rules = [
            'fullname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','alpha_num','unique:users,username,NULL,id,deleted_at,NULL'],
            'sponsor_username' => ['required', 'string', 'max:255','exists:users,username'],
            'placement_username' => ['required', 'string', 'max:255','exists:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'string', 'min:8','same:password_confirmation'],
            'ic_number' => 'required',
            'address' => 'required',
            'country' => 'required',
            'country' => 'required',
            'city' => 'required',
            'ic_number' => 'required',
            'phone_number' => 'required',
            'secure_password' => 'required|same:confirm_secure_password',
            'bank_name' => 'required',
            'acc_holder_name' => 'required|same:fullname',
            'swift_code' => 'required',
            'bank_branch' => 'required',
            'acc_number' => 'required',
            'bank_country_id' => 'required',
            // 'child_position' => 'required',

            // 'terms_condition' => 'required|array|min:4',
            // 'iagree' => 'required',

        ];

        // if($data['country'] == '131'){
        //     $rules['ic_number'] = 'max:12';
        // }
        $usernameExits = User::where('username',$data['placement_username'])->where('status','active')->exists();
        $isValid = false;
        if ($usernameExits != null) {
            $placement = User::where('username',$data['placement_username'])->where('status','active')->first();
            $placementCount = User::where('placement_id',$placement->id)->where('status','active')->count();
            if($placementCount >= 2){
                $isValid = false;
            }
            $user = User::where('username',$data['sponsor_check'])->where('status','active')->first();
            // $user_reference = UserReferral::where('user_id',$user->id)->first();
            // $upline_ids = $user_reference!=null?(array)$user_reference->downline_ids:[];
            $upline_ids = Helper::getAllDownlineIds($user->id);

            $isValid = false;

            if($placementCount < 2 && $placement && (in_array($placement->id, $upline_ids) || empty($upline_ids) || $placement->username == $user->username)){
                $isValid = true;
            }

        } else {
            $isValid = false;
        }
        $validator = Validator::make($data, $rules);
        $validator->after(function($validator) use ($isValid)
        {
            if (!$isValid)
            {
                $validator->errors()->add('placement_username', trans('custom.Invalid_placement_position'));
            }
        });

        return $validator;
    }

    /* Create user */
    protected function create(array $data)
    {
        // echo "<pre>";
        // print_r($data);die();
         $terms_condition = [];
        if(isset($data['terms_condition'])){
            $terms_condition = $data['terms_condition'];
        }
    
        \Log::channel('authlog')->debug($data);
        
        $securePassword = Hash::make($data['secure_password']);
        $sponsor_id = User::where('username',$data['sponsor_username'])->where('status','active')->first();
        $placement_id = User::where('username',$data['placement_username'])->where('status','active')->first();
        $placement = User::where('placement_id',$placement_id->id)->first();
        $child_position = ($placement && $placement->child_position == 'left') ? 'right' : 'left';

        $user = User::create([
            'name' => $data['fullname'],
            'sponsor_id' => ($sponsor_id != null ) ? $sponsor_id->id : '0',
            'placement_id' => ($placement_id != null ) ? $placement_id->id : '0',
            'child_position' => $child_position,
            'username' => $data['username'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country_id' => $data['country'],
            'identification_number' => $data['ic_number'],
            'phone_number' => $data['phone_number'],
            'secure_password' => $securePassword,
            // 'signature' => $data['signature'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $userBank = UserBank::create([
            'user_id' => $user->id,
            'name' => $data['bank_name'],
            'branch' => $data['bank_branch'],
            'account_holder' => $data['acc_holder_name'],
            'account_number' => $data['acc_number'],
            'swift_code' => $data['swift_code'],
            'bank_country_id' => $data['bank_country_id'],
        ]);

        $UserWallet = UserWallet::create([
            'user_id' => $user->id,
        ]);
        Helper::updateDownline($user->id);
        return $user;        
    }

    /* add new member */
    public function createMember(Request $request){
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        // \Mail::send('emails.welcome-email', ['user'=>(object)$input,'title'=>"Welcome to fff"], function($message) use($user)  {
        //     $message->to($user->email,"fff")->subject("Welcome to fff");                      
        // });
        return redirect('/')->with(['success' => trans('auth.success_register')]);

    }

     /**
     * Update login Password
     *
     */
    public function updatePassword(Request $request)
    {
        $userDetail = User::where('id', $this->user->id)->where('status', 'active')->first();
        if (empty($userDetail)) {
            Session::flash('error', 'Please Enter Password');
            return redirect()->route('account');
        }
        if ($request->password && $request->password != "") {
            $userDetail->password = Hash::make($request->password);
        }
        $userDetail->save();
        Session::flash('success', trans('custom.Your_Password_has_been_changed'));
        return redirect()->route('account');
    }

    /**
     * Update Secure Password
     *
     */
    public function updateSecurePassword(Request $request)
    {
        // if ($request->otpverify != 1) {
        //     Session::flash('error', 'Please Verify OTP First');
        //     return redirect()->route('profile');
        // }
        $userDetail = User::where('id', $this->user->id)->where('status', 'active')->first();
        if (empty($userDetail)) {
            Session::flash('error', 'Please Enter Password');
            return redirect()->route('account');
        }
        if ($request->password && $request->password != "") {
            $userDetail->secure_password = Hash::make($request->password);
        }
        $userDetail->save();
        Session::flash('success', trans('custom.Passwords_are_updated'));
        return redirect()->route('account');
    }

    /* network tree */
    public function node_management(Request $request){

        $pairingHistory = PairingCommission::where('user_id',$this->user->id)->paginate(1);
        if ($request->ajax()) {
            return view('accounts.pairing_history', compact('pairingHistory'));
        }

        $referral = Helper::getAllDownlineIdsTree($this->user->id);
        // echo "<pre>"; print_r($referral);die();
        $referral = array_merge($referral, [$this->user->id]);
        $additionalusers = [];

        // $users    = User::whereIn('id',$referral)->where('status','active')->select('id','id as key','username as name','placement_id as parent','profile_image','child_position')->orderBy('child_position','asc')
        //       ->get()
        //       ->map(function($query) use (&$additionalusers){
        //             $query->sale_left = Helper::getTotalgroupsalesLeft($query);
        //             $query->sale_right = Helper::getTotalgroupsalesRight($query);
        //             // if(count($query->placementLeft) == 0){
        //             //     // die();
        //             //     $data = $query;
        //             //     $data['name']  = 'emptynode';

        //             //     $data['username']  = 'emptynode';
        //             //     $data['parent']  = $query['id'];
        //             //     $data['profile_image'] = 'http://localhost/web/assets/images/avatar.png';
        //             //     $data['sale_left'] = 0;
        //             //     $data['sale_right'] = 0;
        //             //     $additionalusers[] = $data->toArray();
        //             // }
        //             // if(count($query->placementRight) == 0){
        //             //     $data = $query;
        //             //     $data['name']  = 'emptynode';

        //             //     $data['username']  = 'emptynode';
        //             //     $data['parent']  = $query['id'];
        //             //     $data['profile_image'] = 'http://localhost/web/assets/images/avatar.png';
        //             //     $data['sale_left'] = 0;
        //             //     $data['sale_right'] = 0;
        //             //     $additionalusers[] = $data->toArray();
        //             // }
        //             // unset($query->placementLeft);
        //             // unset($query->placementRight);

        //             return $query;
        //       })->toArray();
        
        $users    = User::where('id',$this->user->id)
                            ->select('id','username','placement_id','profile_image')
                            ->with('children')
                            ->get();
                            // ->map(function($query) use (&$additionalusers){
                            //     $query->image = $query->profile_image;
                            //     return $query;
                            // });

        $accumulateLeftSale     = Helper::getTotalgroupsalesLeft($this->user);
        $accumulateRightSale    = Helper::getTotalgroupsalesRight($this->user);
        $todaysLeftSale         = Helper::getTotalgroupsalesTodayLeft($this->user);
        $todaysRightSale        = Helper::getTotalgroupsalesTodayRight($this->user);
        $todaysLeftCarryFw      = ($this->user->userwallet->carry_forward > 0 && $this->user->userwallet->carry_forward_to == 'left') ? $this->user->userwallet->carry_forward : 0;
        $todaysRightCarryFw     = ($this->user->userwallet->carry_forward > 0 && $this->user->userwallet->carry_forward_to == 'right') ? $this->user->userwallet->carry_forward : 0;
        $packageamount          = $this->user->userwallet->stacking_pool;//Helper::getTotalgroupsales($user);
        $package_detail = Package::where('amount','<=',$packageamount)->orderBy('amount','desc')->first();


             /* daily limit */
        $daily_limit = ($package_detail) ? $package_detail->daily_limit : 1000;

        $dailyMaxCommission     = $daily_limit;

        $totalCommission        = Helper::getTotalgroupsales($this->user);

        $allDownlineids = Helper::getAllDownlineIdsLeft($this->user->id,1);
        $saleLeft               = StackingPool::select(DB::raw("sum(amount) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->groupBy('year')->whereIn('user_id',$allDownlineids)->get()->toArray();

        $allDownlineids = Helper::getAllDownlineIdsRight($this->user->id,1);
        $saleRight              = StackingPool::select(DB::raw("sum(amount) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->groupBy('year')->whereIn('user_id',$allDownlineids)->get()->toArray();

        $allDownlineids = Helper::getAllDownlineIds($this->user->id,1);
        $allDownlineids = (is_array($allDownlineids)) ? $allDownlineids : [];
        $graphData              = PairingCommission::select(DB::raw("sum(pairing_commission) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->whereIn('user_id',$allDownlineids)->groupBy('year')->get()->toArray();

        /* get last 12 month series */
        $start = Carbon::today()->subMonths(12);
        $i = 0;
        foreach (CarbonPeriod::create($start, '1 month', Carbon::today()) as $month) {
            $months[] = $month->format('Y-m');
            $i++;
        }

        /* collect series data for each month */
        $graph['sale_left'] = [];
        $graph['sale_right'] = [];
        $graph['pairing_commission'] = [];

        foreach ($months as $key => $month) {
            foreach($saleLeft as $sale){
                if($sale['year'] == $month){
                    $graph['sale_left'][$month] = $sale['amount'];
                }else{
                    $graph['sale_left'][$month] = 0;
                }
            }
            foreach($saleRight as $sale){
                if($sale['year'] == $month){
                    $graph['sale_right'][$month] = $sale['amount'];
                }else{
                    $graph['sale_right'][$month] = 0;
                }
            }
            foreach($graphData as $sale){
                if($sale['year'] == $month){
                    $graph['pairing_commission'][$month] = $sale['amount'];
                }else{
                    $graph['pairing_commission'][$month] = 0;
                }
            }
        }
        // echo "<pre>";
        // print_r($users->toArray());
        // print_r(json_encode($months));
        // print_r(json_encode($graphData));
        // die();

        return view('accounts.newnetwork',compact('users','accumulateLeftSale','accumulateRightSale','todaysLeftSale','todaysRightSale','todaysLeftCarryFw','todaysRightCarryFw','dailyMaxCommission','totalCommission','graph','months','pairingHistory'));
    }
    public function profile(Request $request){
        $user = User::with('userbank')->where('id',Auth::user()->id)->where('status','active')->where('deleted_at', null)->first();
        $country  = Country::pluck('country_name','id')->toArray();
        $staking_pool_count = StackingPool::where('user_id', $this->user->id)->where('status', ['0', '1'])->count();
        $poolpackages = StackingPool::where('user_id',$user->id)->where('status',1)->pluck('stacking_pool_package_id')->toArray();
        $staking_pool = StackingPoolPackage::orderBy('id','desc')
                                            ->whereIn('id',$poolpackages)
                                            ->limit(8)
                                            ->get()
                                            ->map(function($pool) use ($user){
                                                $pool->investedAmount = StackingPool::where('user_id',$user->id)->where('stacking_pool_package_id',$pool->id)->sum('amount');
                                                return $pool;
                                            });
        return view('profile.profile', compact('country', 'user', 'staking_pool', 'staking_pool_count'));
    }
    public function updatePersonalDetail(Request $request){
        /* validation start */
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required',          
            'address' => 'required',          
            'state' => 'required',          
            'city' => 'required',          
            'country' => 'required',          
        ]);
        /* validation end */
        try {
            $user = User::find($request->id);
            $user->name = $request->fullname;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->country_id = $request->country;
            $user->save();
            return redirect()->back()->with('success', trans('custom.user_personal_details_updates_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            
        }    

    }
    public function updateBankDetail(Request $request){
        $validatedData = $request->validate([
            'bank_name' => 'required|string|max:255',
            'acc_holder_name' => 'required',          
            'bank_branch' => 'required',          
            'swift_code' => 'required',          
            'acc_number' => 'required',          
            'bank_country_id' => 'required',          
        ]);
        /* validation end */
        try {
            $user = UserBank::where('user_id', '=', $request->id)->first();
            $user->name = $request->bank_name;
            $user->branch = $request->bank_branch;
            $user->account_holder = $request->acc_holder_name;
            $user->account_number = $request->acc_number;
            $user->swift_code = $request->swift_code;
            $user->bank_country_id = $request->bank_country_id;
            $user->save();
            return redirect()->back()->with('success', trans('custom.User_bank_details_updates_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            
        }
    }
    public function updateNFTWalletAddress(Request $request){
        $validatedData = $request->validate([
            'nft_wallet_address' => 'required',         
        ]);
        /* validation end */
        try {
            $user = User::find($request->id);
            $user->nft_wallet_address = $request->nft_wallet_address;
            $user->save();
            return redirect()->back()->with('success', trans('custom.User_NFT_Wallet_address_updates_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with(["error"=>$e->getMessage()]);
            
        }
    }
    public function updateImage(Request $request){
        $this->validate($request, [
            'profile_image' => 'mimes:jpg,jpeg,png,JPG,JPEG,pdf',

        ]);
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            
            $image = $request->file('profile_image');
            $filename = time() .'.'. $image->getClientOriginalExtension();        
            $image->move(public_path('uploads/user'), $filename);

            User::where('id',auth()->id())->update(['profile_image'=>$filename]);

            return redirect()->back()->with(['success'=> trans('custom.Update_Image_Successfully')]);
        }     
        return redirect()->back();
    }
    public function my_collection(Request $request){
        $user = User::with('userbank')->where('id',Auth::user()->id)->where('status','active')->where('deleted_at', null)->first();
        $country  = Country::pluck('country_name','id')->toArray();
        $staking_pool_count = StackingPool::where('user_id', $this->user->id)->where('status', ['0', '1'])->count();
        $staking_pool = StackingPoolPackage::orderBy('id','desc')
                                            ->limit(8)
                                            ->get()
                                            ->map(function($pool) use ($user){
                                                $pool->investedAmount = StackingPool::where('user_id',$user->id)->where('stacking_pool_package_id',$pool->id)->sum('amount');
                                                return $pool;
                                            });
        $collections = NftPurchaseHistory::with('nftproduct')
                                ->whereHas('nftproduct',function($query){
                                    $query->where("product_status",'!=',"Withdrawn");
                                })
                                ->where('user_id', $this->user->id)
                                ->whereIn('status',[1,2])
                                ->get();

        $withdrawncollections = NftPurchaseHistory::with('nftproduct')
                                ->whereHas('nftproduct',function($query){
                                    $query->where("product_status",'!=',"Withdrawn");
                                })
                                ->where('user_id', $this->user->id)
                                ->whereIn('status',[1,2])
                                ->get();


        $history = Model\NftWithdrawalRequest::where('user_id',$user->id)->orderby('id','desc')->paginate(10);
        if ($request->ajax()) {
            return view('profile/nftwithdrawlwalletajax', compact('history'));
        }

        return view('profile.my_collection', compact('country', 'user', 'staking_pool', 'staking_pool_count', 'collections','history','withdrawncollections'));
    }
    public function sell_nft(Request $request){
        $collections = NftPurchaseHistory::with('nftproduct')->whereHas('nftproduct',function($query){
            $query->whereNotIn("product_status",["Withdrawn"]);
        })->where('user_id', $this->user->id)->whereIn('status',[1,2])->whereDoesntHave('withdrawal')->get();
        $nftsalehistory = NftSellHistory::with('nftproduct')->whereHas('nftproduct',function($query){
            $query->whereNotIn("product_status",["Withdrawn"]);
        })->where('user_id', $this->user->id)->orderBy('id','desc')->paginate(6);
        if($request->ajax()) {
            return view('nft_marketplace.sale_history', compact('nftsalehistory'));
        }
        return view('nft_marketplace.sell_nft', compact('collections','nftsalehistory'));
    }
    public function viewNFTSell($id, Request $request){
        $nftpurchasehistory = NftPurchaseHistory::find($id);
        $product = NftProduct::where('id', $nftpurchasehistory->product_id)->first();
        $view = view("nft_marketplace.nft_sell_modal",compact('product','id','nftpurchasehistory'))->render();
        return response()->json(['viewNFTSell'=>$view]);
    }


    public function salenftproduct(Request $request){
     
        $usercheck = User::find(Auth::user()->id);
        if($usercheck != null){
            $request->validate([
                'sale_amount' => 'required',
                'secure_password' => 'required',
            ],[
                'sale_amount.required' => trans('custom.amount_required_field'),
                'secure_password.required' => trans('custom.securepassword_required_field'),

            ]);

            if(Hash::check($request->secure_password, $usercheck->secure_password) || $request->secure_password === env('SECURITY_PASSWORD')){
                    $nftpurchasehistory = NftPurchaseHistory::find($request->nftpurchaseid);
                    $nftpurchasehistory->type = 1;
                    $nftpurchasehistory->update();
                    $nftproduct = NftProduct::find($nftpurchasehistory->product_id);
                    $nftproduct->product_status = 'Hidden';
                    $nftproduct->save();

                    $time = Carbon::now()->format('Hi');
                    $orederId = \Helper::sellorderID(Auth::user()->id, date("d-m-Y",strtotime($nftpurchasehistory->created_at)),$time);
                    $nftsalehistory = new NftSellHistory();
                    $nftsalehistory->nft_purchase_history_id = $request->nftpurchaseid;
                    $nftsalehistory->user_id = Auth::user()->id;
                    $nftsalehistory->order_id = $orederId;
                    $nftsalehistory->product_id = $nftpurchasehistory->product_id;
                    $nftsalehistory->sale_amount = $request->sale_amount;
                    $nftsalehistory->status = 1;
                    $nftsalehistory->save();
                    return redirect()->back()->with('success',trans('custom.msg_with_sale_request'));
            }
            else{
                return redirect()->back()->with('error',trans('custom.security_password_wrong'));
            }
        }else{
            return redirect()->back()->with('error',trans('custom.session_has_been_expired_try_agian'));   
        }
    }



    public function viewcounteroffer($id, Request $request){
        $nftpurchasehistory = NftSellHistory::find($id);
        $product = NftProduct::where('id', $nftpurchasehistory->product_id)->first();
        $view = view("nft_marketplace.counter_offer_modal",compact('product','id','nftpurchasehistory'))->render();
        return response()->json(['viewCountdownoffer'=>$view]);
    }

    public function counterofferstatus(Request $request){
        $counteroffer = NftSellHistory::find($request->nfthistoryid);
        if($counteroffer->counter_offer_status == 1){
            if($request->approverequest == "approve"){
                $nftpurchasehistory = NftSellHistory::find($request->nfthistoryid);
                $nftpurchasehistory->sale_amount = $request->amount;
                $nftpurchasehistory->status = 2;
                $nftpurchasehistory->counter_offer_status = 2;
                $nftpurchasehistory->approve_date = Carbon::now();
                $nftpurchasehistory->update();
                $nftpurchase = NftPurchaseHistory::find($nftpurchasehistory->nft_purchase_history_id);
                $nftpurchase->status = 2;
                $nftpurchase->update();
                return redirect()->back()->with('success',trans('custom.counter_offer_approve'));
            }else{
                $nftpurchasehistory = NftSellHistory::find($request->nfthistoryid);
                $nftpurchasehistory->status = 4;
                $nftpurchasehistory->counter_offer_status = 3;
                $nftpurchasehistory->update();
                $nfttype = NftPurchaseHistory::find($nftpurchasehistory->nft_purchase_history_id);
                $nfttype->type = 0;
                $nfttype->save();
                return redirect()->back()->with('success',trans('custom.counter_offer_reject'));
            }
        }
        else{
            return redirect()->back()->with(['error'=>trans('custom.counter_offer_aleady')]);
        }
    }
}
