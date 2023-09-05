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
    public function index(Event $event)
    {
        return Inertia::render('Organization/Attendees',[
            'event'=>$event,
            'attendees'=>$event->attendees()
        ]);
    }
    public function scan(){
        dd('attendees scan');
    }

    public function update(){
        dd('attendees update');
    }

}
