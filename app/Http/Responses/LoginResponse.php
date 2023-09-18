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
        // dd(Auth()->user()->member);
        // $member= Member::where('user_id',auth()->user()->id)->with('guardian')->first();
        $member=Auth()->user()->member;
        if($member){
            if($member->organizations->count()>0){
                session(['organization'=>$member->organizations[0]]);
                return redirect()->route('member.dashboard');
            }
            return Inertia::render('Error',[
                'message'=>"You don't belongs to any organization"
            ]);
        }
        if(Auth()->user()->organizations->count()>0){
            session(['organization'=>Auth()->user()->organizations[0]]);
            return redirect()->route('manage.dashboard');
        // }else{
        //     return Inertia::render('Error',[
        //         'message'=>"You don't belongs to any organization"
        //     ]);
        }
        if(Auth()->user()->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        // session(['organization'=>$member->organizations[0]]);
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