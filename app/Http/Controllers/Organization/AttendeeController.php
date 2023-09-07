<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Attendee;

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
            'attendees'=>$event->attendees(),
            'members'=>session('organization')->members
        ]);
    }
    public function store(Event $event, Request $request){
        if($request->model=='member'){
            $event->members()->syncWithoutDetaching($request->data);

        }else{
            $list=$request->data;
            foreach($list as $i=>$d){
                $list[$i]['event_id']=$event->id;
            };

            Attendee::upsert($list,['event_id','display_name'],['event_id','display_name']);
        }
        
        dd($request->all());
    }
    public function scan(){
        dd('attendees scan');
    }

    public function update(){
        dd('attendees update');
    }

}
