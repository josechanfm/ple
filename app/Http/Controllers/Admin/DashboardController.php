<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->user()->hasRole(['admin','master'])) {
            return Inertia::render('Admin/Dashboard',[
                //'organizations'=>auth()->user()->organizations
                'organizations'=>Organization::all()
            ]);
        }else{
            return redirect('/');
        }

    }
    
}
