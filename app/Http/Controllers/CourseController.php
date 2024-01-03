<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;

class CourseController extends Controller
{
    public function show(Course $course){
        return Inertia::render('Course', [
            'course'=>$course
        ]);

    }
}
