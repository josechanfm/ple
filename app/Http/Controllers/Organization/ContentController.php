<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Course;
use App\Models\Content;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * // @return \Illuminate\Http\Response
     * @return \Inertia\Response
     */
    public function index(Course $course)
    {
        $course->contents;
        return Inertia::render('Organization/Contents',[
            'course'=>$course,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * // @return \Illuminate\Http\Response
     * @return \Inertia\Response
     */
    public function create(Course $course)
    {
        return Inertia::render('Organization/Content',[
            'course'=>$course,
            'content'=>Content::make([
                'course_id'=>$course->id
            ]),
            'content_types'=>Config::item('content_types')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Course $course, Request $request)
    {
        $data=$request->all();

        $data['course_id']=$course->id;
        $data['frontpage']=$data['frontpage']??0;
        Content::create($data);
        return redirect()->route('manage.course.contents.index',$course->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * // @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * // @return \Illuminate\Http\Response
     * @return \Inertia\Response
     */
    public function edit(Course $course, Content $content)
    {
        return Inertia::render('Organization/Content',[
            'course'=>$course,
            'content'=>$content,
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
    public function update(Course $course, Content $content, Request $request)
    {
        // dd($request->all());
        $content->update($request->all());
        return redirect()->route('manage.course.contents.index',$course->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Content $content, Request $request)
    {
        $content->delete();
        return redirect()->back();
    }
}
