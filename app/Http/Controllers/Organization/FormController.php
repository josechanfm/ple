<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FormController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Organization::class);
        $this->authorizeResource(Form::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('view',$organization);
        
        return Inertia::render('Organization/Forms',[
            'organization' => session('organization'),
            'forms'=>session('organization')->fresh()->forms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
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
            'name'=>'required',
            'title'=>'required',
        ]);
        $organization = Organization::find($request->organization_id);

            $form=new Form();
            $form->organization_id=$request->organization_id;
            $form->name=$request->name;
            $form->title=$request->title;
            $form->description=$request->description;
            $form->require_login=$request->require_login;
            $form->for_member=$request->for_member;
            $form->published=$request->published;
            $form->save();
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization, Form $form)
    {
        // $this->authorize('view',$organization);
        // $this->authorize('view',$form);

        echo 'edit form';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization, Form $form)
    {
        //$this->authorize('update',$organization);
        //$this->authorize('update',$form);
        // return Inertia::render('Organization/FormEdit',[
        //     'fields'=>$form->fields
        // ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $this->validate($request,[
            'organization_id' => 'required',
            'name'=>'required',
            'title'=>'required',
        ]);
        $organization = Organization::find($request->organization_id);

        if($organization->hasUser(Auth()->user())){
            $form->name=$request->name;
            $form->title=$request->title;
            $form->description=$request->description;
            $form->require_login=$request->require_login;
            $form->for_member=$request->for_member;
            $form->published=$request->published;
            $form->save();
            if($request->file('image')){
                $form->addMedia($request->file('image')[0]['originFileObj'])->toMediaCollection('image');
            }
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization, Form $form)
    {
        if($form->hasChild()){
            return redirect()->back()->withErrors(['message'=>'No permission or restriced deletion of records with child records.']);
        }else{
            $form->delete();
            return redirect()->back();
        }
    }

    public function deleteMedia(Media $media){
        $media->delete();
    }
}