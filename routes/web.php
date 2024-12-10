<?php

use App\Http\Controllers\AcceptAnswerController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\BookmarkQuestionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VoteQuestionController;
use Illuminate\Support\Facades\Route;


Route::get('/', [QuestionController::class, 'index'])->name('questions.index');

Route::get('/questions/{question:slug}', [QuestionController::class, 'show'])->name('questions.show');

Route::middleware('auth')->group(function () {
    Route::resource('questions', QuestionController::class)
        ->except(['index', 'show']); 
    Route::resource('/questions.answers', AnswerController::class)
        ->only(['store', 'update', 'destroy' ]);
    Route::post('/questions/answers/{answer}/accept', AcceptAnswerController::class)
        ->name('questions.answers.accept');
    Route::post('/questions/{question}/bookmark', [BookmarkQuestionController::class, 'store'])
        ->name('questions.bookmark.store');
    Route::post('questions/{question}/vote', VoteQuestionController::class)
        ->name('questions.vote');
    Route::delete('/questions/{question}/delete', [BookmarkQuestionController::class, 'destroy'])
        ->name('questions.bookmark.destroy');
    
});
