<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{

    public function index(Request $request)
    {

        $filter = $request->query('filter', 'latest');

        $questions = Question::with(['user', 'tags']) // tadi error tags tidak bisa diampilkan, solusinya Tambahkan 'tags' di sini
            ->withCount('answers')
            ->when($filter === 'mine', function ($query) {
                $query->mine();
                // Filter untuk pertanyaan yang dimiliki oleh user saat ini
            })
            ->when($filter === 'unanswered', function ($query) {
                $query->doesntHave('answers');
                // Filter untuk pertanyaan yang belum dijawab
            })
            ->when($filter === 'scored', function ($query) {
                $query->whereNotNull('best_answer_id');
                // Filter untuk pertanyaan yang telah dijawab dan diberi skor
            })
            ->when($filter === 'most_answered', function ($query) { 
                $query->withCount('answers')                             // Hitung jumlah jawaban
                    ->orderByDesc('answers_count');                      // Urutkan berdasarkan jumlah jawaban terbanyak
                // Filter untuk pertanyaan dengan jumlah jawaban terbanyak
            })
            ->when($filter === 'latest', function ($query) {
                $query->latest();
                // Default untuk pertanyaan terbaru
            })
            ->paginate(10)
            ->appends(['filter' => $filter]);

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
            'question' => QuestionResource::make($question),
            'answers' => AnswerResource::collection(
                $question->answers()->latest()->paginate(7)
            ),
        ]);
    }


    public function edit(string $id)
    {
        //
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);

        $question->update($request->validated());

        return back()->with('success', 'Your Question Has Been Updated');
    }

 
    public function destroy(Question $question)
    {
         Gate::authorize('delete', $question);

        $question->delete();

        return back()->with('success', "Your Question Has Been Deleted");
    }
}
