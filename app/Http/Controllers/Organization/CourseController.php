<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Content;
use App\Models\Course;
use App\Models\Config;

class CourseController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(Course::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(auth()->user()->courses);

        return Inertia::render('Organization/Courses',[
            'courses'=>auth()->user()->courses
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request->all());
        // return Inertia::render('Organization/Course',[
        //     'course'=>Course::make([
        //         'organization_id'=>session('organization')->id,
        //     ])
        // ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $data['organization_id']=session('organization')->id;
        $json=[["value"=>"defaultmodule","label"=>"Default Module"]];
        $data['modules']=$json;
        $course=Course::create($data);
        $course->users()->attach(auth()->user(),['actor_code'=>'OTH']);

        $content_data['course_id']=$course->id;
        $content_data['user_id']=auth()->user()->id;
        $content_data['module']='defaultmodule';
        $content_data['type']= 'PAGE';
        $content_data['title']= 'DefaultTitle';
        Content::create($content_data);

        return redirect()->route('manage.courses.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        // return Inertia::render('Organization/Course',[
        //     'course'=>$course->with('contents')->first(),
        //     'content_types'=>Config::item('content_types')
        // ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        // dd($course->modules);
        $course->contents;
        return Inertia::render('Organization/Course',[
            'course'=>$course,
            'content_types'=>Config::item('content_types')
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Course $course, Request $request)
    {
        dd($request->all());
        dd($course->update($request->all()));
        $course->update($request->all());
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

    public function createModule(Request $request)
    {
        dd($request->all());
        
    }
}
