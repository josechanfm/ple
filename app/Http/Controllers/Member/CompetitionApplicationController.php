<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Competition;
use App\Models\Config;
use App\Models\CompetitionApplication;

class CompetitionApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition)
    {
        return Inertia::render('Member/CompetitionApplicationForm',[
            'competition'=>$competition,
            'categories_weights'=>Config::categories_weights(),
            'roles'=>Config::item('competition_roles'),
            'member'=>auth()->user()->member
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Competition $competition)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Competition $competition, Request $request)
    {
        //dd($competition);
        $data=$request->all();
        if($data['role']=='athlete'){
            //max 2 applicatition same competition, in defferent category and/or weight
            $applicationCount=CompetitionApplication::where('competition_id',$data['competition_id'])
                            ->where('member_id',$data['member_id'])
                            ->count();
            if($applicationCount>=2){
                return redirect()->back()->withErrors(['message'=>'You have 2 applications']);
            }
            //max 1 in same category same weight
            $applicationCount=CompetitionApplication::where('competition_id',$data['competition_id'])
                            ->where('member_id',$data['member_id'])
                            ->where('category',$data['category'])
                            ->where('weight',$data['weight'])
                            ->count();
            if($applicationCount>=1){
                return redirect()->back()->withErrors(['message'=>'Duplicate in same category and/or weight']);
            }
            $applicationCount=CompetitionApplication::where('competition_id',$data['competition_id'])
                            ->where('member_id',$data['member_id'])
                            ->where('role','!=','athlete')
                            ->count();
            if($applicationCount>=1){
                return redirect()->back()->withErrors(['message'=>'Applied multiple roles']);
            }
        }else{
            //max 1 in same category same weight
            $applicationCount=CompetitionApplication::where('competition_id',$data['competition_id'])
                            ->where('member_id',$data['member_id'])
                            ->count();
            if($applicationCount>=1){
                return redirect()->back()->withErrors(['message'=>'Duplicate application']);
            }
            
        }
        CompetitionApplication::create($data);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
