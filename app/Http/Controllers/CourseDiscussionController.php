<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseDiscussionController extends Controller
{
    public function index(Course $course)
    {
        return Inertia::render('Course/Discussion', [
            'course' => $course,
            'forum' => $course->forum
        ]);
    }

    public function show(Course $course, Discussion $discussion)
    {
        $discussion->load('posts');

        return Inertia::render('Course/DiscussionDetail', [
            'course' => $course,
            'discussion' => $discussion
        ]);
    }
    public function store(Course $course, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'discussion_id' => 'nullable|exists:discussions,id'
        ]);

        $discussion = new Discussion();
        $discussion->fill($request->all());
        $discussion->save();

        return redirect()->route('course.discussion.thread', [
            'course' => $course,
            'discussion' => $request->discussion_id
        ]);
    }
}
