<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $currentRoute = Route::current();
        // dd();

        if($currentRoute->uri == '/'){
            if( auth()->check()){
                if(auth()->user()->division_id == 1){
                    return redirect('/sales');
                    // dd('sales');
                }else if(auth()->user()->division_id == 2){
                    return redirect('/teknisi');
                    // dd('teknisi');
                }else{
                    return redirect('/admin');
                    // dd('admin');
                }
            }
        }



        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
