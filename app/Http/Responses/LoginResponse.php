<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Models\Member;
use Inertia\Inertia;

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
        $member= Member::where('user_id',auth()->user()->id)->with('guardian')->first();
        if($member->organizations->count()<=0){
            return Inertia::render('Error',[
                'message'=>"You don't belongs to any organization"
            ]);
        };
        session(['organization'=>$member->organizations[0]]);
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