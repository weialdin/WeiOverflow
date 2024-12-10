<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function questions() 
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function bookmarks()
    {

        return $this->belongsToMany(Question::class, 'bookmarks')->withTimestamps();
    
    }

    public function voteQuestion()
    {
        return $this->morphedByMany(Question::class, 'voteable');
    }

    public function VotingQuestion(Question $question, int $vote)
    {
        $voteQuestion = $this->voteQuestion();

        if ($voteQuestion->where('voteable_id', $question->id)->exists()) {
            $voteQuestion->updateExistingPivot($question, ['vote' => $vote]);
        } else {
            $voteQuestion->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $question->votes_count = $question->votes()->sum('vote');
        $question->save();

    }





    public function avatarUrl()
    {
        $email = strtolower(trim($this->email));
        $hash = hash('sha256', $email);
        return "https://www.gravatar.com/avatar/". $hash;
    }
}
