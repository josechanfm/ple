<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Event;
use App\Models\Attendance;
use Attribute;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->hasPermissionTo('attendance')){
            return Inertia::render('Error',[
                'message'=>"You don't have permission for taking attendance."
            ]);
            return redirect()->route('member.dashboard');
        };
        if(!session('organization')){
            return redirect()->route('member.dashboard');
        };
        $instances=Attendance::getInstances();
        return Inertia::render('Member/Attendances',[
            'instances'=>$instances,
            'members'=>session('organization')->members
        ]);
    }

    public function modify(Event $event){
        $event->attendances;
        return Inertia::render('Member/AttendancesModify',[
            'event'=>$event,
            'members'=>session('organization')->members
        ]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Event $event)
    {
        $data=$request->all();
        $data['event_id']=$event->id;
        $data['user_id']=auth()->user()->id;

        Attendance::updateOrCreate(['event_id'=>$event->id,'member_id'=>$request->member_id],['status','user_id']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event, Attendance $attendance)
    {
        $attendance->status=$request->status;
        $attendance->save();
        return redirect()->back();
    }
    public function sync(Request $request, Event $event){
        //return response()->json($request->all());
        $data=[];
        foreach($request->all() as $memberId){
            $data[]=['event_id'=>$event->id,'member_id'=>$memberId,'status'=>'ATT','user_id'=>auth()->user()->id];
        };
        Attendance::upsert(
            $data,
            ['event_id','member_id','status','user_id'],
            ['status','user_id']
        );
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->back();
    }

    public function scan(Event $event){
        // $member=Member::find(2);
        // dd(session('organization'));
        // dd($member->ownedBy(session('organization')));
        return Inertia::render('Member/AttendanceScan',[
            'event'=>$event
        ]);
    }
    public function getMember(Request $request){
        $event=Event::find($request->event_id);
        $member=Member::find($request->scan[0]);
        if(!$member->ownedBy(session('organization'))){
            return response()->json(['result'=>false,'member'=>$member,'message'=>'Not belongs to this organization.']);
        }
        //return response()->json($member->ownedBy(session('organization')));
        $data['event_id']=$event->id;
        $data['member_id']=$member->id;
        $data['status']='ATT';
        $data['user_id']=auth()->user()->id;
        //$attendance=Attendance::updateOrCreate(['event_id'=>$event->id,'member_id'=>$member->id],['status','user_id']);
        //$attendance=Attendance::upsert([$data],['event_id','member_id'],['status','user_id']);
        $attendance=Attendance::where('event_id',$data['event_id'])->where('member_id',$data['member_id'])->first();
        if($attendance){
            return response()->json(['result'=>false,'member'=>$member,'message'=>'Already existed.']);
        }else{
            Attendance::create($data);
            return response()->json(['result'=>true,'member'=>$member,'message'=>'Successfully checked.']);
        }
        
        //return response()->json($member);
    }
}
