<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Form;
use App\Models\Entry;
use App\Models\EntryRecord;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            if(auth()->user()->member){
                $orgIds=auth()->user()->member->organizations->pluck('id')->toArray();
                $forms=Form::where('published',1)->where('for_member',1)->whereIn('organization_id',$orgIds)->get();
            }else{

                $forms=Form::where('published',1)->where('required_login',1)->get();
            }
        }else{
            $forms=Form::where('published',1)->get();
        }
        return Inertia::render('Form/Form',[
            'forms'=>$forms
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
        $entry=new Entry();
        $entry->form_id=$request->form['id'];
        $entry->save();
        foreach($request->fields as $key=>$value){
            $record=new EntryRecord();
            $record->entry_id=$entry->id;
            $record->form_field_id=$key;
            if(is_array($value)){
                $record->field_value=json_encode($value);
            }else{
                $record->field_value=$value;
            }
            $record->save();
        }
        $form=Form::find($entry->form_id);
        return Inertia::render('Form/Thanks',[
            'form'=>$form,
            'filled'=>$entry,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        if(!$form->published){
            return redirect()->back();
        }elseif($form->require_login && auth()->user()==null){
            return redirect()->back();
        }elseif($form->for_member){
            if(auth()->user()->member==null){
                return redirect()->back();
            }
            $orgIds=auth()->user()->member->organizations->pluck('id')->toArray();
            if(!in_array($form->organization_id, $orgIds)){
                return redirect()->back();
            }
        };
        
        //$form=Form::with('fields')->find($id);
        $form->fields;
        if($form->require_login==1 && !Auth()->user()){
            return redirect('forms');
        }
        return Inertia::render('Form/FormDefault',[
            'form'=>$form,
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
