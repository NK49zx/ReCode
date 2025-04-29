<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'firstname',
        'lastname',
        'bio',
        'is_active',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    // User's questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // User's bookmark records
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Questions bookmarked by user
    public function bookmarkedQuestions()
    {
        return $this->belongsToMany(Question::class, 'bookmarks')
                    ->withTimestamps();
    }

    // User's answers
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    // User's question votes
    public function questionVotes(): HasMany
    {
        return $this->hasMany(QuestionVote::class);
    }

    // Questions user voted on
    public function votedQuestions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_votes')
                    ->withPivot('type')
                    ->withTimestamps();
    }
}
