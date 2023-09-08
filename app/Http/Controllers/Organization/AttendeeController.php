<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
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
            'members'=>session('organization')->members,
            'attendance_status'=>Config::item('attendance_status')
        ]);
    }
    public function update(Event $event, Attendee $attendee, Request $request){
        $attendee->display_name=$request->display_name;
        $attendee->status=$request->status;
        $attendee->save();
        return redirect()->back();
    }
    public function store(Event $event, Request $request){
        if($request->model=='member'){
            $event->members()->sync($request->data);
        }else{
            $list=$request->data;
            foreach($list as $i=>$d){
                $list[$i]['event_id']=$event->id;
            };
            Attendee::upsert($list,['event_id','display_name'],['event_id','display_name']);
        }
        return redirect()->back();
    }
    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->back();
    }

}
