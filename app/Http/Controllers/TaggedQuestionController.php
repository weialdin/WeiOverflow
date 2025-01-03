<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TaggedQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Tag $tag)
    {
        $questions = $tag->questions() // Perbaikan: Panggil metode relasi `questions`
            ->with(['user', 'tags']) 
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return inertia('Questions/Index', [
            'questions' => QuestionResource::collection($questions),
            'tag' => $tag
        ]);
    }

}
