<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;


class QuestionController extends Controller
{
    
    public function index()
    {
            $questions = QuestionResource::collection(
            Question::with('user')->latest()->paginate(10)
        );

        return inertia('Questions/Index', [
            'questions' => $questions
        ]);
    }

   
    public function create()
    {
        //
    }

  
    public function store(StoreQuestionRequest $request)
    {
        $request->user()->questions()->create(
            $request->validated()
        );

        return back()->with('success', "Your Question has been submitted");
    }

  
    public function show(Question $question)
    {
        return inertia('Questions/Show', [
            'question' => QuestionResource::make($question)
        ]);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return back()->with('success', 'Your Question Has Been Updated');
    }

 
    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('success', "Your Question Has Been Deleted");
    }
}
