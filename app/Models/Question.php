<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    // Fields that can be filled using mass assignment
    protected $fillable = [
        'title',
        'context',
        'alt_content',
        'user_id',
        'is_answered',
        'views'
    ];

    /**
     * Get the user that owns the question.
     */
    // Relationship: question belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tags associated with the question.
     */
    // Relationship: question has many tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the answers for the question.
     */
    // Answers for this question
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    // Bookmark records for this question
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Users who bookmarked this question
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')
                    ->withTimestamps();
    }

    // Votes for this question
    public function votes()
    {
        return $this->hasMany(QuestionVote::class);
    }

    // Get the user's vote on this question
    public function userVote($user)
    {
        return $this->votes()->where('user_id', $user->id)->first();
    }

    // Calculate net vote score (upvotes - downvotes)
    public function voteScore()
    {
        return $this->votes()->where('type', 'upvote')->count() - 
               $this->votes()->where('type', 'downvote')->count();
    }

    // Get the user's vote
    public function userVoteQ($user)
    {
        if (!$user) return null;
        return $this->votes()->where('user_id', $user->id)->first();
    }

    // Calculate net vote score (upvotes - downvotes)
    public function voteScoreQ()
    {
        return $this->votes()->where('type', 'upvote')->count() - 
               $this->votes()->where('type', 'downvote')->count();
    }
}
