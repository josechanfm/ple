<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Approbate;
use App\Models\Organization;

class ApprobateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Organization/Approbates',[
            'approbates' => Approbate::with('media')->get(),
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
        $this->validate($request,[
            'organization_id' => 'required',
        ]);
        $organization = Organization::find($request->organization_id);

        $approbate=new Approbate();
        $approbate->organization_id=$request->organization_id;
        $approbate->name=$request->name;
        $approbate->title=$request->title;
        $approbate->description=$request->description;
        $approbate->start_date=isset($request->start_date)?$request->start_date:NULL;
        $approbate->end_date=isset($request->end_date)?$request->start_date:NULL;
        $approbate->active=isset($request->active)?$request->active:0;
        $approbate->save();
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
    public function update(Request $request, Approbate $approbate)
    {
        $this->validate($request,[
            'organization_id' => 'required',
            'name'=>'required',
        ]);

        $approbate->name=$request->name;
        $approbate->title=$request->title;
        $approbate->description=$request->description;
        $approbate->start_date=isset($request->start_date)?$request->start_date:NULL;
        $approbate->end_date=isset($request->end_date)?$request->start_date:NULL;
        $approbate->active=isset($request->active)?$request->active:0;
        $approbate->save();
        return redirect()->back();
        
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
