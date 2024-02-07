<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //Admin
            if (Auth::user()->role == 'admin') {
                return redirect(route('admin.dashboard.index'));
            }

            //Controller
            if(Auth::user()->role == 'controller'){
                return redirect(route('controller.dashboard.index'));
            }

            //Marketing Panel
            if(Auth::user()->role == 'marketing_panel'){
                return redirect(route('marketing_panel.dashboard.index'));
            }

            //Marketer User
            if(Auth::user()->role == 'marketer'){
                return redirect(route('marketer.home.index'));
            }


            //Worker
            if (Auth::user()->role == 'worker') {
                return redirect(route('worker.home.index'));
            }

            //Membership
            if (Auth::user()->role == 'membership') {
                return redirect(route('membership.home.index'));
            }
            
            //Customer
            if (Auth::user()->role == 'customer') {
                return redirect(route('customer.home.index'));
            }
        }
        return $next($request);
    }
}
