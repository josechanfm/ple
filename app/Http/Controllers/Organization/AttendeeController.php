<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Form;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, $id)
    {
        $instance=null;
        switch($type){
            case 'event':
                $instance=Event::find($id);
                break;
            case 'form':
                $instance=Form::find($id);
                break;
        }
        if(!$instance) return redirect()->route('/');
        return Inertia::render('Organization/Attendees',[
            'attendees'=>$instance->members
        ]);
        //$event->members()->sync([1,2,3,4]);
    }
    public function scan(){
        dd('attendees scan');
    }

    public function update(){
        dd('attendees update');
    }

}
