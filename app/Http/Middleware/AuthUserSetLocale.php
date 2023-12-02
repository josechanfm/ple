<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserSetLocale
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
        // if(session('locale')){
        //     app()->setLocale(session('locale'));
        //     $request->except(0); 
        //     // dd(session('locale'));
        // }elseif(auth()->user() && auth()->user()->locale){
        //     //\App::setLocale(auth()->user()->locale);
        //     //config(['app.locale'=>auth()->user()->locale]);
        //     app()->setLocale(auth()->user()->locale);
        //     $request->except(0); 
        //     //dd(auth()->user()->locale);
        // }


        return $next($request);
    }
}
