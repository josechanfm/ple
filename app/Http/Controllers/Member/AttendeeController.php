<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Form;
use App\Models\Attendance;

class AttendeeController extends Controller
{
    public function index($type, $id){
        if(!session('organization')) return redirect()->route('/');
        $instance=null;
        switch($type){
            case 'event':
                $instance=Event::find($id);
                break;
            case 'form':
                $instance=Form::find($id);
                break;
            case 'attendance':
                $instance=Attendance::find($id);
                break;
        };
        if(!$instance) return redirect()->route('/'); 
        //$instance->members()->sync([1,2,3,4]);
        return Inertia::render('Member/Attendees',[
            'attendees'=>$instance->members,
            'members'=>session('organization')->members
        ]);
    }
    public function scan(){
        dd('scan');
    }
    public function update(){
        dd('update');
    }
}
