<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Competition;
use App\Models\CompetitionApplication;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Competition/Competitions',[
            'competitions'=>Competition::where('scope','<>','ORG')->get()
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
        //dd($competition);
        $data=$request->all();
        $competition=Competition::find($data['competition_id']);
        if($competition->scope!='PUB'){
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
        }
        CompetitionApplication::create($data);
        //return redirect()->back();
        return redirect()->route('competitions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        return Inertia::render('Competition/ApplicationForm',[
            'belt_ranks'=>Config::item("belt_ranks"),
            'competition'=>$competition,
            'member'=>auth()->user()?auth()->user()->member:null
        ]);

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
