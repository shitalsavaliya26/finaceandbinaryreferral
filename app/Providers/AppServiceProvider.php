<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Auth;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\StackingPool;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer(['*'], function ($view) {
            if (Auth::check() && auth()->user()->userwallet) {
                $totalstaking_pool = auth()->user()->userwallet->crypto_wallet;
                $minstakeamount = Setting::where('key','min_stackingpool_amount')->value('value');
                $today = Carbon::today();
                $before12Month  = Carbon::today()->subDays(365);
                $before24Month  = Carbon::today()->subDays(730);
                $user_investments = StackingPool::whereIn('status',[0,1])
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

                $view->with('planExpired', $planExpired);
                $view->with('expired_stacking_pools', $expired_stacking_pools);
                $view->with('max_stake', $totalstaking_pool);
                $view->with('min_stake', $minstakeamount);


            }
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
    }
}
