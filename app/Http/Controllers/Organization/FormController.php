<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form;
use App\Models\Entry;
use App\Models\EntryRecord;
use App\Models\Event;
use App\Models\Attendees;
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
        //dd(Form::find($formId)->entries()->delete());
        // echo ($entries);
        // echo ($form);

        //$this->authorize('view',$organization);
        return Inertia::render('Organization/Forms',[
            'organization' => Organization::find(session('organization')->id),
            'forms'=>Organization::find(session('organization')->id)->forms
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
        if($organization->id!=session('organization')->id){
            return redirect()->back();
        };
        $form->name=$request->name;
        $form->title=$request->title;
        $form->description=$request->description;
        $form->require_login=$request->require_login;
        $form->for_member=$request->for_member;
        $form->published=$request->published;
        $form->with_attendance=$request->with_attendance;
        $form->save();
        //dd($request->file('image'));
        if($request->file('image')){
            //dd($request->file('image')[0]['originFileObj']->originalName);
            
                $form->addMedia($request->file('image')[0]['originFileObj'])->toMediaCollection('image');
            
        }
        return redirect()->back();
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
    public function backup(Form $form){
        //return response()->json($form);
        $data=new \stdClass();
        $form->fields;
        //$data->form=Form::with('fields')->find($formId);
        $data->form=$form;

        if($data->form){
            $data->entries=Entry::where('form_id',3)->with('records')->get();
            $file=\Storage::put('dbbackup/'.$data->form->organization_id.'/form_'.$data->form->id.'_'.time().'.txt',json_encode($data));
            if($file){
                $data->entries;
            };
            //dd($file);
            $ids=Entry::where('form_id',$data->form->id)->pluck('id')->toArray();
            EntryRecord::whereIn('entry_id',$ids)->delete();
            Entry::where('form_id',$data->form->id)->delete();
        }
        return response()->json($data);
    }

    public function deleteMedia(Media $media){
        $media->delete();
    }

    public function createEventAttendees(Request $request, Form $form){
        $event=Event::where('form_id',$form->id)->first();
        if(empty($event)){
            $event=new Event();
        }
        $event->organization_id=$form->organization_id;
        $event->category_code='FORM';
        $event->title_en=$form->title;
        $event->credit=0;
        $event->start_date=null;
        $event->end_date=null;
        $event->form_id=$form->id;
        $event->with_attendance=true;
        $event->save();
        $event->entries()->syncWithoutDetaching($request->all());      
        return redirect()->back();
    }
}