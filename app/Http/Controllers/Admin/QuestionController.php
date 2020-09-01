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
        //
    }

    
    public function show(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

   
    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}