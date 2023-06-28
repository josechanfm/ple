<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\Organization;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        /*
        if(auth()->user()->guardian){
            session(['guardian'=>auth()->user()->guardian]);
            return redirect('guardian');
        }
        if (auth()->user()->hasRole(['organizer','admin','master'])) {
            $organizations=auth()->user()->organizations;
            if($organizations->count()==0){
                Auth::guard('web')->logout();
                return redirect('manage');
            }else if($organizations->count()==1){
                session(['organization'=>$organizations[0]]);
                return redirect('manage/dashboard');
            }else{
                return redirect('manage');
            }
        }
        */
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(config('fortify.home'));
    }
}