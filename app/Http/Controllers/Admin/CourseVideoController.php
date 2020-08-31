<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\course;
use App\Video;

class CourseVideoController extends Controller
{
    
     // create video to specific video
    public function create(course $course)
    {
        return view('admin.courses.createvideo', compact('course'));
    }

    
    public function store(Request $request, course $course)
    {
        $rules=[
            'title' => 'required|min:10|max:100',
            'link' => 'required|url',
            'course_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $Video = Video::create($request->all());

        if($Video){
            return redirect('/admin/courses/'.$course->id)->withState('Video successfully created.');
        } else{
            return redirect('/admin/courses/'.$course->id.'/createvideo')->withState('something wrong happened, Try again.');
        }
    }

   
    
}
