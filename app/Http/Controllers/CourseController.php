<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Content;
use Inertia\Response;

class CourseController extends Controller
{
    public function show(Course $course){
        return Inertia::render('Course/Dashboard', [
            'course'=>$course
        ]);
    }
    public function study(Course $course){
        $COLUMNS = 'id,course_id,module,type,title,start_on,finish_on';

        $course->load(['contents'=>function($query) use($COLUMNS){
            $query->selectRaw($COLUMNS);
            // TODO: filter contents by start_on and finish_on
        }]);

        return Inertia::render('Course/Study', [
            'course'=>$course->with('contents')->first(),
            'groupedContent' => $course->groupedContents()
        ]);
    }

    /**
     * 課程內容
     *
     * @param Course $course
     * @param Content $content
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function content(Course $course, Content $content){
        switch ($content->type) {
            case 'URL':
                return Inertia::location(trim($content->content));
        }

        return Inertia::render('Course/Content', [
            'course'=>$course,
            'content'=>$content
        ]);
    }
}
