<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
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
    public function index(Event $event)
    {
        $event->attendances;
        return Inertia::render('Member/Attendances',[
            'event'=>$event,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return resonpose()->json($attendance);
    }
}
