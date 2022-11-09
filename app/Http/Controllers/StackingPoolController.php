<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StackingPoolPackage;
use App\Models\StackingPool;
use App\Models\UserWallet;
use App\Models\User;
use Auth,Session,Hash;
use Carbon\Carbon;

class StackingPoolController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index(){
        $user = $this->user;
        $staking_pool = StackingPoolPackage::orderBy('id','desc')
                                            ->get()
                                            ->map(function($pool) use ($user){
                                                $pool->investedAmount = StackingPool::where('user_id',$user->id)->where('stacking_pool_package_id',$pool->id)->sum('amount');
                                                return $pool;
                                            });
        return view('stacking_pool.index',compact('staking_pool'));
    }

    /* pool package detail */
    public function detail($id,Request $request){
        $stakingpool = StackingPoolPackage::find($id);
        $stackHistory = StackingPool::where('user_id',$this->user->id)->where('stacking_pool_package_id',$id)->orderBy('id','desc')->paginate(6);
        $totalInvested = StackingPool::where('user_id',$this->user->id)->where('stacking_pool_package_id',$id)->sum('amount');
        if ($request->ajax()) {
            return view('stacking_pool.stack_history', compact('stackHistory'));
        }
        $user = $this->user;
        $today = Carbon::today();
        $before12Month  = Carbon::today()->subDays(365);
        $before24Month  = Carbon::today()->subDays(730);
        $user_investments = StackingPool::whereIn('status',[0,1])
                                        ->where('stacking_pool_package_id',$id)
                                        ->where('user_id',auth()->user()->id)
                                            ->where(function($query) use ($today,$before12Month,$before24Month){ 
                                                $query
                                                ->where(function($q1) use ($before12Month){
                                                    $q1->whereDate('start_date','<',$before12Month)
                                                    ->where('stacking_period','12');
                                                })
                                                ->orWhere(function($q1) use ($before24Month){
                                                    $q1->whereDate('start_date','<',$before24Month)
                                                    ->where('stacking_period','24');
                                                });
                                            })
                                            ->get();
        $planExpired = false;
        $expired_stacking_pools = [];
        foreach ($user_investments as $key => $user_investment) {
            if($user_investment->start_date_week <= $today && $user_investment->end_date_week > $today){
                $planExpired = true;
                $expired_stacking_pools[] = $user_investment;
            }
        }
        $user_investments = $expired_stacking_pools;
        return view('stacking_pool.stackpool',compact('stakingpool','stackHistory','user','totalInvested','user_investments'));
    }

    /* invest in pool package */
    public function stacking_pool(Request $request){
        $this->validate($request, [
            'stacking_pool_package_id' => "required",
            'amount' => 'required',
            'security_password' => 'required',
            'duration'=>'required',
            // 'signature'=>'required'
        ]);
        $usercheck = $this->user;
        $isError = 0;
        $pool = StackingPoolPackage::where('id',$request->stacking_pool_package_id)->first();
        // echo '<pre>'; print_r($request->security_password); die();
        if($usercheck != null && $pool){
            if(Hash::check($request->security_password , $usercheck->secure_password) || $request->security_password === env('SECURITY_PASSWORD')){

                $crypto_wallet = auth()->user()->userwallet->crypto_wallet;
                if($crypto_wallet < $request->amount){
                    Session::flash('error',trans('custom.minimum_amount_less_wallet'));
                    return redirect()->route('stakepool',$request->stacking_pool_package_id)->withInput($request->input());
                }
                $start_date = Carbon::today();
                $end_date = Carbon::today()->addDay(365 * ($request->duration / 12));
                // die('test');
                $pool = StackingPool::create(['user_id' => $usercheck->id,
                                     'stacking_pool_package_id' => $request->stacking_pool_package_id,
                                     'amount' => $request->amount,
                                     'stacking_period' => $request->duration,
                                     'start_date' => $start_date,
                                     'end_date' => $end_date,
                                     'signature' => $request->signature]);
                // $pool = StackingPool::where(['user_id' => $usercheck->id])->orderBy('id','desc')->first();
                // print_r($pool->id);
                    // die();
                $command = "php artisan calculate:directreferral ".$pool->id." > /dev/null 2>/dev/null &";
                if($usercheck->promo_account == 0){
                    shell_exec($command);
                }
                UserWallet::where('user_id',$usercheck->id)->decrement('crypto_wallet',round($request->amount,2));
                UserWallet::where('user_id',$usercheck->id)->increment('stacking_pool',round($request->amount,2));

                Session::flash('success',trans('custom.staking_pool_added_successfully'));

            }else{
                $isError = 1;
                Session::flash('error',trans('custom.security_password_wrong'));   
            }
        }else{
            $isError = 1;
            Session::flash('error',trans('custom.session_has_been_expired_try_agian'));   
        }
        if($isError == 1 ){
            return redirect()->route('stakepool',$request->stacking_pool_package_id)->withInput($request->input());
        }

        return redirect()->route('stakepool',$request->stacking_pool_package_id);
    }

    /* investment period expired */
    public function investmentperiod($id){
        $stacking_pool = StackingPool::find($id);
        $before12Month  = Carbon::today()->subDays(365);
        $before24Month  = Carbon::today()->subDays(730);

        // $timeperiods = [$before12Month=>'12',$before24Month=>'24'];
        $view = view('stacking_pool/partials/plan_expired',compact('stacking_pool'))->render();
        return response()->json(['status'=>'success','html'=>$view]);
        return view('stacking_pool/partials/plan_expired',compact('stacking_pool','timeperiods'));
    }

    /* change plan period */
    public function changePlan($id,Request $request){
        $this->validate($request, [
                        'changeplan' => 'required',
                        'duration'=>'required'
                    ]);
        $user_investment = StackingPool::find($id);
        if($request->changeplan == 'changeplan'){

            $start_date = Carbon::today();
            $end_date = Carbon::today()->addDay(365 * ($request->duration / 12));
            $data = [
                        'description' => 'renew_invested',
                        'start_date' => Carbon::now()->format('Y-m-d'),
                        'end_date' => $end_date,
                        'stacking_period' => $request->duration
                    ];
            $user_investment->update($data);
            Session::flash('success',trans('custom.success_investment_period_change'));
        }else{
            $user_investment->status = 2;
            $user_investment->save();
            UserWallet::where('user_id',$user_investment->user_id)->increment('crypto_wallet',round($user_investment->amount,2));
            UserWallet::where('user_id',$user_investment->user_id)->decrement('stacking_pool',round($user_investment->amount,2));

            Session::flash('success',trans('custom.success_close_investment'));
            
        }
        return redirect()->route('stakepool',$user_investment->stacking_pool_package_id)->withInput($request->input());
    }
}

