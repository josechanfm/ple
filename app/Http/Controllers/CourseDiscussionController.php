<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
        $discussion->load(['posts.user', 'user']);

        $discussion = $discussion->toArray();
        // if the user is deleted, we will show a deleted user
        if ($discussion['user'] === null) {
            $discussion['user'] = User::DELETED_USER()->toArray();
        }

        foreach ($discussion['posts'] as &$post) {
            if ($post['user'] === null) {
                $post['user'] = User::DELETED_USER()->toArray();
            }
        }

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

        auth()->user()->discussions()->save($discussion);

        return redirect()->route('course.discussion.thread', [
            'course' => $course,
            'discussion' => $request->discussion_id
        ]);
    }

    /**
     * @param Course $course
     * @param Discussion $discussion
     * @return RedirectResponse
     */
    public function destroy(Course $course, Discussion $discussion): RedirectResponse
    {
        // TODO: validate if is the same user or is admin
        if (!auth()->user()->isDiscussionOwner($discussion)) {
            abort(403);
        }

        $discussion->delete();

        return redirect()->back();
    }
}
