<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Competition;
use App\Models\Config;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Organization/Competitions',[
            'competitions'=>Competition::paginate()
        ]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd(Config::categories_weights());
        //dd(Config::item('competition_roles'));
        return Inertia::render('Organization/Competition',[
            //'competitiom'=>array('organization_id'=>session('organization')->id,'title_en'=>'','period'=>null,'match_dates'=>[],'roles'=>[]),
            'categories_weights'=>Config::categories_weights(),
            'roles'=>Config::item('competition_roles')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $competition=new Competition();
        $competition->organization_id=session('organization')->id;
        $competition->title_en=$request->title_en;
        $competition->title_fn=$request->title_fn??null;
        $competition->start_date=date('Y-m-d',strtotime($request->period[0]));
        $competition->end_date=date('Y-m-d',strtotime($request->period[1]));
        $competition->match_dates=$request->match_dates;
        $competition->categories_weights=$request->categories_weights;
        $competition->roles=$request->roles;
        $competition->save();

        return response($competition);
        //return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        return Inertia::render('Organization/CompetitionShow',[
            'competitionSource'=>$competition,
            'categories_weights'=>Config::categories_weights(),
            'roles'=>Config::item('competition_roles')
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Competition $competition)
    {
        return Inertia::render('Organization/Competition',[
            'competitionSource'=>$competition,
            'categories_weights'=>Config::categories_weights(),
            'roles'=>Config::item('competition_roles')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        //$competition->organization_id=session('organization')->id;
        $competition->title_en=$request->title_en;
        $competition->title_fn=$request->title_fn??null;
        $competition->start_date=date('Y-m-d',strtotime($request->period[0]));
        $competition->end_date=date('Y-m-d',strtotime($request->period[1]));
        $competition->match_dates=$request->match_dates;
        $competition->categories_weights=$request->categories_weights;
        $competition->roles=$request->roles;
        $competition->save();

        return response($request->all());
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
