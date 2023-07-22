<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Classify;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $member=Member::where('user_id',auth()->user()->id)->with('guardian')->first();

        //login user has guardian role
        if(auth()->user()->guardian){
            session(['guardian'=>auth()->user()->guardian]);
            return redirect()->route('member.guardian');
        }

        //login user is member
        if($member){
            $organizations=$member->organizations;
            $member->portfolios;
            session(['organization'=>$member->organizations[0]]);
            return Inertia::render('Member/Dashboard',[
                'member'=>$member,
                'current_organization'=>session('organization'),
                //'articles'=>Classify::whereBelongsTo(session('organization'))->first()->articles
            ]);
        }

        //login user not a member but with specific roles
        if (auth()->user()->hasRole(['admin','master'])) {
            return redirect('admin');
        }
                
    }
   
}
