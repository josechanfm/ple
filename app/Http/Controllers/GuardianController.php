<?php

namespace App\Http\Controllers;

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
            return redirect('login');
        }
        return Inertia::render('Guardian',[
            'guardian'=>session('guardian'),
            //'guardian'=>Guardian::where('user_id',auth()->user()->id)->with('members')->first(),
            'members'=>session('guardian')->members
        ]);
    }

    public function actAs(Member $member){
        Auth::guard('web')->login($member->user);
        Auth::guard('sanctum')->setUser($member->user);
        return redirect()->route('dashboard');
    }
}
