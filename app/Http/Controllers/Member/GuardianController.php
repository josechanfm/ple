<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Member;
use App\Models\Guardian;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{
    //

    public function index(){
        if(session('guardian')==null){
            return redirect('member.login');
        }
        return Inertia::render('Member/Guardian',[
            'guardian'=>session('guardian'),
            //'guardian'=>Guardian::where('user_id',auth()->user()->id)->with('members')->first(),
            'members'=>session('guardian')->members
        ]);
    }
    public function back(){
        if(session('guardian')){
            $user=User::find(session('guardian')->user_id);
            Auth::guard('web')->login($user);
            Auth::guard('sanctum')->setUser($user);
            auth()->user()->fresh;
        }
        return redirect()->route('member.guardian');
    }
    public function actAs(Member $member){
        Auth::guard('web')->login($member->user);
        Auth::guard('sanctum')->setUser($member->user);
        return redirect()->route('member.dashboard');
    }
}
