<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Quiz;
use App\Question;

class QuizQuestionController extends Controller
{
    
    
    public function create(Quiz $quiz)
    {
        return view('admin.quizzes.createquestion', compact('quiz'));
    }

    
    public function store(Request $request)
    {
        //
    }

    
    
}
