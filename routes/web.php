<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama (index)
Route::get('/', [QuestionController::class, 'index'])->name('questions.index');

Route::get('/questions/{question:slug}', [QuestionController::class, 'show'])->name('questions.show');

Route::middleware('auth')->group(function () {
    Route::resource('questions', QuestionController::class)
        ->except(['index', 'show']); 
});
