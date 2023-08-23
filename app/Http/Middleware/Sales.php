<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Sales
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
            abort(403);
        }

        if(auth()->user()->is_admin == 0){
            if(auth()->user()->division_id != 1){
                abort(403);
            }
        }
                
        
        return $next($request);
    }
}
