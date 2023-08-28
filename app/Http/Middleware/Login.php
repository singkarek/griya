<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( !auth()->check()){
            // dd('belom login');
            return redirect('/');
        }

        if(auth()->user()->is_admin == 0){
            if(auth()->user()->division_id != 1){
                // abort(403);
                // dd(auth()->user()->division_id);

                // if(auth()->user()->division_id){
                //     return redirect()->intended('/teknisi');
                // }

                if(auth()->user()->division_id == 1){
                    return redirect('/sales');
                }else if(auth()->user()->division_id == 2){
                    return redirect('/teknisi');
                }else{
                    return redirect('/admin');
                }
            }
        }

        return $next($request);
    }
}
