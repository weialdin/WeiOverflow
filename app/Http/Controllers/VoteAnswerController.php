<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Answer $answer, Request $request)
    {
        $vote = (int) $request->vote;

        $request->user()->votingAnswer($answer, $vote);
        
        return back()->with('success', 'The answer has been voted');
    }
}
