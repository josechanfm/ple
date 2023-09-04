<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Form;
use App\Models\Attendance;
use App\Models\Attendee;
use App\Models\Member;

class AttendeeController extends Controller
{
    public function index($type, $id){
        if(!auth()->user()->hasPermissionTo('attendance')){
            return redirect()->route('member.dashboard');
        }
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
        $members=array_column(session('organization')->members->toArray(),null,"id");
        $participants=array_column($instance->participants->toArray(),null,'id');
        $attendedMembers=array_column($instance->attendedMembers->toArray(),null,'id');
        $attendedParticipants=array_column($instance->attendedParticipants->toArray(),null,'id');
        $attendees=$instance->attendees;

        // dd($members);
        //dd($participants);
        // dd($attendedParticipants);
        //dd($attendedMembers);
        foreach($members as $id=>$m){
            $members[$id]['attended']=isset($attendedMembers[$id])?true:false;
        };
        foreach($participants as $id=>$participant){
            $participants[$id]['attended']=isset($attendedParticipants[$id])?true:false;
        };
        foreach($attendees as $id=>$attendee){
            $attendees[$id]['attended']=true;
        };
        foreach($attendedMembers as $id=>$a){
            $attendedMembers[$id]['attended']=true;
        }
        // dd($participants);
        //dd($members);
        // dd($instance->attendedParticipants);
        // dd($instance->attendedMembers);
        //$instance->members()->sync([1,2,3,4]);
        return Inertia::render('Member/Attendees',[
            'members'=>$members,
            'participants'=>$participants,
            'attendedMembers'=>$attendedMembers,
            'attendedParticipants'=>$attendedParticipants,
            'attendees'=>$attendees,
            //'members'=>session('organization')->members,
            //'participants'=>$instance->participants,
            //'attendees'=>$instance->members,
            'instance'=>$instance,
            'type'=>$type
        ]);
    }
    public function scan($type,$id){
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
        return Inertia::render('Member/AttendeeScan',[
            'type'=>$type,
            'instance'=>$instance
        ]);
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
