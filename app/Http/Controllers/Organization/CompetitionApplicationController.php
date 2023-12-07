<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Competition;
use App\Models\CompetitionApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use PDF;
use App\Exports\CompetitionApplicationExport;
use Maatwebsite\Excel\Facades\Excel;

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
        Session::put('competitionId', $competition->id); 
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

    public function receipts(Competition $competition, Request $request){
        if(!session('competitionId') || session('competitionId')!=$competition->id){
            return redirect()->route('/');
        }
        $applications=CompetitionApplication::whereIn('id',explode(',',$request->applicationIds))->get();
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        // return view('Competition.ApplicationReceipt',[
        //     'competition'=>$competition,
        //     'applications'=>$applications
        // ]);
        $pdf=PDF::loadView('Competition.ApplicationReceipt',[
            'competition'=>$competition,
            'applications'=>$applications
        ]);
        $pdf->render();
        return $pdf->stream('receipts.pdf',array('Attachment'=>false));

    }
    public function export(Competition $competition){
        
        //echo $applications;
        //dd('aa');
        //dd($competition);
        return Excel::download(new CompetitionApplicationExport($competition), 'applications.xlsx');
    }
}
