<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\News;
use App\Models\User;
use App\Models\Slider;
use App\Helpers\Helper;
use App\Models\Package;
use App\Models\Setting;
use Carbon\CarbonPeriod;
use App\Models\NftProduct;
use App\Models\UserWallet;
use App\Models\NftCategory;
use App\Models\StackingPool;

use Illuminate\Http\Request;
use App\Models\NftPurchaseLog;
use App\Models\NftSellHistory;
use App\Models\PairingCommission;
use App\Models\NftPurchaseHistory;
// use App\Models\NftReservedProduct;
use App\Models\ReferralCommission;
use App\Models\YieldWalletHistory;
use App\Models\StackingPoolPackage;
use App\Models\CommissionWalletHistory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     $this->middleware(function ($request, $next) {
        $this->user = Auth::user();
        return $next($request);
    });
       $this->middleware('auth');
   }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard(){
        $user = $this->user;
        $sliders = Slider::all();
        $staking_pool = StackingPoolPackage::orderBy('id','desc')
                                            ->limit(8)
                                            ->get()
                                            ->map(function($pool) use ($user){
                                                $pool->investedAmount = StackingPool::where('user_id',$user->id)->where('stacking_pool_package_id',$pool->id)->sum('amount');
                                                return $pool;
                                            });
        $nft_cats = NftCategory::where('is_deleted','0')->where('status','active')->orderBy('order_id', 'ASC')->orderBy('id','DESC')->get();
        $locale = app()->getLocale();


        $total_stacking = StackingPool::where('user_id', $this->user->id)
                                        ->where(function($q){
                                            $q->where('status','0')->orWhere('status','1');
                                        })
                                        ->sum('amount');
        // if ($locale == 'en' || $locale == 'ko' || $locale == 'th' || $locale == 'vi') {
        //     $locale = 'en';
        // } else {
        //     $locale = 'cn';
        // }
        $news = News::where(['status' => 'active', 'lang' => $locale])->orderBy('created_at', 'desc')->take(5)->get();
        $allDownlineids = Helper::getAllDownlineIds($this->user->id,1);
        $allDownlineids = (is_array($allDownlineids)) ? $allDownlineids : [];

        $pairing_commissions = PairingCommission::select(DB::raw("sum(pairing_commission) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->where('user_id',$user->id)->groupBy('year')->get()->toArray();
        $referral_commissions = ReferralCommission::select(DB::raw("sum(amount) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->where('user_id',$user->id)->groupBy('year')->get()->toArray();
        $roi_commissions = YieldWalletHistory::select(DB::raw("sum(amount) as amount"),DB::raw("DATE_FORMAT(created_at,'%Y-%m') as year"))->where('description','ROI')->where('user_id',$user->id)->groupBy('year')->get()->toArray();


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
            foreach($referral_commissions as $sale){
                if($sale['year'] == $month){
                    $graph['referral_commission'][$month] = $sale['amount'];
                }else{
                    $graph['referral_commission'][$month] = 0;
                }
            }

            foreach($roi_commissions as $sale){
                if($sale['year'] == $month){
                    $graph['roi_commission'][$month] = $sale['amount'];
                }else{
                    $graph['roi_commission'][$month] = 0;
                }
            }

            foreach($pairing_commissions as $sale){
                if($sale['year'] == $month){
                    $graph['pairing_commission'][$month] = $sale['amount'];
                }else{
                    $graph['pairing_commission'][$month] = 0;
                }
            }
        }

         /* commission graph */
        $commissionData = [];
        /* last month */
        $lastyear = Carbon::now()->subMonth()->format('Y');
        $lastmonth = Carbon::now()->subMonth()->format('m');
        $commissionData[$lastmonth]['apr_monthly'][] = __('custom.apr_monthly');
        $commissionData[$lastmonth]['apr_monthly'][] = round(PairingCommission::whereYear('created_at',$lastyear)->whereMonth('created_at',$lastmonth)->where('user_id',$user->id)->sum('pairing_commission'),2);

        $commissionData[$lastmonth]['referral_commission'][] = __('custom.referral_commission');
        $commissionData[$lastmonth]['referral_commission'][] = round(ReferralCommission::whereYear('created_at',$lastyear)->whereMonth('created_at',$lastmonth)->where('user_id',$user->id)->sum('amount'),2);

        $commissionData[$lastmonth]['balancing_commission'][] = __('custom.balancing_commission');
        $commissionData[$lastmonth]['balancing_commission'][] = round(YieldWalletHistory::whereYear('created_at',$lastyear)->whereMonth('created_at',$lastmonth)->where('description','ROI')->where('user_id',$user->id)->sum('amount'),2);

        /* this month */
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $commissionData[$month]['apr_monthly'][] = __('custom.apr_monthly');
        $commissionData[$month]['apr_monthly'][] = round(PairingCommission::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('user_id',$user->id)->sum('pairing_commission'),2);

        $commissionData[$month]['referral_commission'][] = __('custom.referral_commission');
        $commissionData[$month]['referral_commission'][] = round(ReferralCommission::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('user_id',$user->id)->sum('amount'),2);

        $commissionData[$month]['balancing_commission'][] = __('custom.balancing_commission');
        $commissionData[$month]['balancing_commission'][] = round(YieldWalletHistory::whereYear('created_at',$year)->whereMonth('created_at',$month)->where('description','ROI')->where('user_id',$user->id)->sum('amount'),2);

        // echo "<pre>";
        // print_r($commissionData);die();
        return view('dashboard',compact('user','sliders','staking_pool','news','nft_cats','graph','months','commissionData','total_stacking'));
    }

    public function crypto_wallets(){
        return view('crypto_wallet.index');
    }

    public function yield_wallet(){
        return view('yield_wallet.index');
    }

    public function commission_wallet(Request $request){
        $userWallet = UserWallet::where('user_id',$this->user->id)->first();
        $history = CommissionWalletHistory::where('user_id',$this->user->id)->where('amount','>',0)->orderby('id','desc')->orderby('id','desc')->paginate(10);
        if($request->ajax()){
            return view('yield_wallet.partials.history',compact('history'));
        }
        return view('commission_wallet.index',compact('userWallet', 'history'));
    }

    public function nft_wallet(){
        return view('nft_wallet.index');
    }

    public function withdrawal(){
        return view('withdrawal.index');
    }

   
    public function ledger(){
        return view('reports.index');
    }

    public function account(){
        return view('profile.profile');
    }


    public function my_collection(){
        return view('profile.my_collection');
    }

    public function help_support(){
        return view('help_support.index');
    }

   
  

    public function downlinePlacement(Request $request){
        $downlineUser = User::where('placement_id',$request->id)->where('status','active')->where('id','!=',$request->id)->get();
        return view('mynetworkdownlinePlacement',compact('downlineUser'));
    }

    
    public function downlineUsers(Request $request){
        $downlineUser = User::where('sponsor_id',$request->id)->where('status','active')->where('id','!=',$request->id)->get();
        return view('mynetworkdownline',compact('downlineUser'));
    }


    public function helpandfaq(){
        return view('help_faq.faq');
    }

}
