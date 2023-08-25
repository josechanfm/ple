<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QrcodeController extends Controller
{
    public function scan(){
        return Inertia::render('Organization/Qrcode',[
        ]);
    }
}
