<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        // if( session('acting_member')!==null ){
        //     $member=Member::where('id',session('acting_member')->id)->first();
        // }else{
        //     $member=Member::where('user_id',auth()->user()->id)->first();
        //     //$member=auth()->user()->member;
        // }
        $member=Member::where('user_id',auth()->user()->id)->with('organizations')->first();
        // dd(auth()->user());
        return Inertia::render('Member/Dashboard',[
            'member'=>$member,
        ]);
    }
   
}
