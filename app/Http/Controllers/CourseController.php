<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Content;

class CourseController extends Controller
{
    public function show(Course $course){
        return Inertia::render('Course/Dashboard', [
            'course'=>$course
        ]);
    }
    public function study(Course $course){
        return Inertia::render('Course/Study', [
            'course'=>$course->with('contents')->first()
        ]);
    }
    public function discussion(Course $course){
        return Inertia::render('Course/Discussion', [
            'course'=>$course,
            'forum'=>$course->forum
        ]);

    }
}
