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

    
    public function store(Request $request, Quiz $quiz)
    {
        $rules=[
            'title' => 'required|min:3|max:1000',
            'answers' => 'required|min:3|max:1000',
            'right_answer' => 'required|min:2|max:50',
            'score' => 'required|integer|in:1,2,3,4,5,10,15,20,25,30',
            'quiz_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $question = Question::create($request->all());

        if($question){
            return redirect('/admin/quizzes/'.$quiz->id)->withStatus('Question Successfully Created.');
        } else{
            return redirect('/admin/quizzes/'.$quiz->id.'/createquestion')->withStatus('Something Wrong Happened, Try Again.');
        }
    }

    
    
}
