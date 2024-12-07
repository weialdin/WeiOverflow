<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Question extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function user()

    {
        return $this->belongsTo(User::class);
    }


    public static function booted(): void

    {

        static::creating(function (Question $question) {
            $question->slug = str($question->title)->slug();
        });
    }


    public function scopeMine(Builder $query)
    {
        //error fix
        if (!$user = Auth::user()) {
            return;
        }

        $query->whereBelongsTo($user);
    }
}
