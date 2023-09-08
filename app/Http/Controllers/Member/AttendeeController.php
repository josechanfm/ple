<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Event;
use App\Models\Form;
use App\Models\Attendance;
use App\Models\Attendee;
use App\Models\Member;

class AttendeeController extends Controller
{
    public function index(Event $event){
        if(!auth()->user()->hasPermissionTo('attendance')){
            return Inertia::render('Error',[
                'message'=>"You don't have permission for taking attendance."
            ]);
            return redirect()->route('member.dashboard');

        }
        if(!session('organization')) return redirect()->route('/');
        
        if(!$event) return redirect()->route('/'); 
        //$event=Event::find($id);
        return Inertia::render('Member/Attendees',[
            'event'=>$event,
            'attendees'=>$event->attendees(),
            'attendance_status'=>Config::item('attendance_status')
        ]);
    }
    public function scan(Event $event){
        if(!$event) return redirect()->route('/'); 
        return Inertia::render('Member/AttendeeScan',[
            'event'=>$event,
            'attendance_status'=>Config::item('attendance_status')
        ]);
    
    }
    public function update(Event $event, Request $request){
        //return response()->json($request->all());
        Attendee::upsert($request->all(),['display_name','status']);

        
        return redirect()->back();
    }

    public function store(Request $request, $type, $id){
        $scanedData=$request->scan;
        $organizationId=$scanedData[0];
        $memberId=$scanedData[1];
        $time=$scanedData[2];
        $hash=$scanedData[3];
        $status=$request->status;
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
        $text=$instance->organization_id.','.$memberId.','.$time;
        $tmpHash=hash('crc32',$text);
        //if not belongs to the save organization, return root
        if($instance->organization_id!==$organizationId){
            //return redirect()->route('/');
        }
        //if hash code not corrected, return root
        if($tmpHash!==$hash){
            //return redirect()->route('/');
        }
        $member=Member::find($memberId);
        $instance->members()->syncWithoutDetaching($memberId,['status'=>$status]);
        $instance->members()->updateExistingPivot($memberId,['status'=>$status]);
        return response()->json(['h'=>$tmpHash,'o'=>$instance->organization_id,'m'=>$memberId,'t'=>$time,'m'=>$member,'r'=>$request->all()]);
    }
    public function storeBatch(Request $request, $type,$id){
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
        $instance->members()->sync($request->attendees);
        //$instance->members()->updateExistingPivot($memberId,['status'=>$status]);
        //return response()->json(['r'=>$request->attendees,'i'=>$instance,'t'=>$type, 'i'=>$id]);
        return redirect()->back();
    }
}
