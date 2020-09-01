<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;

class QuestionController extends Controller
{
    
    public function index()
    {
        $questions = Question::orderby('id', 'desc')->paginate(30);
        return view('admin.questions.index', compact('questions'));
    }

    
    public function create()
    {
        return view('admin.questions.create');
    }

    
    public function store(Request $request)
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
            return redirect('/admin/questions')->withState('Question Successfully Created.');
        } else{
            return redirect('/admin/questions/create')->withState('Something Wrong Happened, Try Again.');
        }
    }

    
    public function show(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

   
    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    
    public function update(Request $request, Question $question)
    {
        //
    }

    
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect('/admin/questions')->withStatus('Question Successfuly Deleted');
    }
}
