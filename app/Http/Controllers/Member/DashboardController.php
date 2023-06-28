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
        $member=Member::where('user_id',auth()->user()->id)->with('guardian')->first();

        if(auth()->user()->guardian){
            session(['guardian'=>auth()->user()->guardian]);
            return redirect()->route('member.guardian');
        }

        // dd(auth()->user()->personalTeam());
        // if(auth()->user()->isMember()){
        if($member){
            $organizations=$member->organizations;
            $member->portfolios;
            session(['organization'=>$member->organizations[0]]);
            return Inertia::render('Member/Dashboard',[
                'member'=>$member,
            ]);
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
                
    }
   
}
