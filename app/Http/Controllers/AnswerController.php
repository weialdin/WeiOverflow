<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Question;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

   
    public function store(StoreAnswerRequest $request, Question $question)
    {
        Answer::create([
            'user_id' => $request->user()->id,
            'question_id' => $question->id,
            'body' => $request->body
        ]);

        return back()->with('success', 'Your answer created successfully.');
    }

    
    public function show(Answer $answer)
    {
        //
    }

    
    public function edit(Answer $answer)
    {
        //
    }

    
    public function update(UpdateAnswerRequest $request, Question $question, Answer $answer)
    {
        // Gate::authorize('update', $answer); --> //via updateAnswerRequest
        
        $answer->update($request->validated());

        return back()->with('success', 'Your answer updated succesfully');
    }

   
    public function destroy(Question $question, Answer $answer)
    {
        Gate::authorize('delete', $answer);
        $answer->delete();

        return back()->with('success', 'Your answer has been deleted');
    }
}
