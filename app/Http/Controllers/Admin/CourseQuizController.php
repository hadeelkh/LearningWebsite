<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\Quiz;

class CourseQuizController extends Controller
{
    
   
    public function create(Course $course)
    {
        return view('admin.courses.createquiz', compact('course'));
    }

    
    public function store(Request $request, Course $course)
    {
        $rules=[
            'name' => 'required|min:3|max:50',
            'course_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $quiz = Quiz::create($request->all());

        if($quiz){
            return redirect('/admin/courses/'.$course->id)->withState('Quiz Successfully Created.');
        } else{
            return redirect('/admin/courses/'.$course->id.'/createquiz')->withState('Something Wrong Happened, Try Again.');
        }
    }

    
}
