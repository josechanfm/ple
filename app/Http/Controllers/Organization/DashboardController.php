<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\AdminUser;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Organization::class);
    }

    public function index()
    {
        //$this->authorize('view',$organization);
        $organizations=auth()->user()->organizations;
        if($organizations->count()==0){
            return to_route('/');
        }else if($organizations->count()==1){
            return Inertia::render('Organization/Dashboard',[
                'organization' => $organizations[0]
            ]);
        }else{
            return Inertia::render('Organization/Selection',[
                'organizations' => $organizations
            ]);

        }

    }
    
}
