<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Organization;
use App;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Organization::class);
    }

    // public function list()
    // {
    //     $organizations=auth()->user()->organizations;
    //     if($organizations->count()==0){
    //         return redirect('/');
    //     }else if($organizations->count()==1){
    //         session(['organization'=>$organizations[0]]);
    //         return redirect()->route('manage.dashboard');
    //     }else{
    //         return Inertia::render('Organization/Selection',[
    //             'organizations' => $organizations
    //         ]);
    //     }
    // }

    public function select(Organization $organization){
        $this->authorize('view',$organization);
        session(['organization'=>$organization]);
        return redirect()->route('manage.dashboard');
    }

    public function index(){
        // if(session('organization')==null){
        //     $organizations=auth()->user()->organizations;
        //     if($organizations->count()==0){
        //         return redirect('/');
        //     }else{
        //         session(['organization'=>$organizations[0]]);
        //     }
        // };
        $this->authorize('view',session('organization'));
        return Inertia::render('Organization/Dashboard',[
            'organizations' => auth()->user()->organizations,
            'member'=>auth()->user()->member
        ]);
        //return redirect()->route('manage.list');

    }
    
}
