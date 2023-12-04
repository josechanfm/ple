<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Competition;
use App\Models\CompetitionApplication;
use Illuminate\Support\Facades\Storage;

class CompetitionApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Competition $competition)
    {
        $competition->applications;
        return Inertia::render('Organization/CompetitionApplications',[
            'competition'=>$competition
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
    public function update(Request $request, Competition $competition, $id)
    {
        $competitionApplication=CompetitionApplication::find($id);
        // return response()->json($competitionApplication);
        // return response()->json($request->all());
        $competitionApplication->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition, $id)
    {   
        $competitionApplication=CompetitionApplication::find($id);
        if($competitionApplication->avatar){
            Storage::delete($competitionApplication->avatar);
        }
        
        $competitionApplication->delete();

        return redirect()->back();
    }
}
