<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;


class QuestionController extends Controller
{
    
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'latest');
        
        $questions = Question::with('user')
            ->when($filter === 'mine', function ($query) {
                $query->mine();
            })
            ->latest()
            ->paginate(10);

        return inertia('Questions/Index', [
            'questions' => QuestionResource::collection($questions),
            'filter' => $filter,
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
