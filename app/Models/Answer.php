<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {

        return $this->belongsTo(User::class);
    
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'voteable');
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer_id;
    }
}

