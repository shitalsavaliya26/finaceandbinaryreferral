<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class Checkuseractive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 'inactive') {
            Auth::logout();
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Your Account is suspended, please contact administrator.'
                );
        }
        return $next($request);
    }
}
