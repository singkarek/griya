<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Admin
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
            return redirect('/');
        }


        if(auth()->user()->is_admin != 1){
            // if(auth()->user()->division_id != 2){
                // abort(403);
                if(auth()->user()->division_id == 1){
                    return redirect('/sales');
                }else if(auth()->user()->division_id == 2){
                    return redirect('/teknisi');
                }
            // }
        }
        // if(auth()->user()->is_admin != 1){
        //     abort(403);
        // }
        return $next($request);
    }
}
