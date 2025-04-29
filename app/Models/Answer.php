<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['question_id', 'user_id', 'content', 'alt_content', 
    'is_accepted', 'upvotes', 'downvotes', 'views', 'comments', 'status'];

    // Relation: Answer belongs to a Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relation: Answer belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: Answer has many Votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Count upvotes for this answer
    public function upvotes()
    {
        return $this->votes()->where('type', 'upvote')->count();
    }

    // Count downvotes for this answer
    public function downvotes()
    {
        return $this->votes()->where('type', 'downvote')->count();
    }

    // Calculate vote score for this answer
    public function voteScore()
    {
        return $this->upvotes() - $this->downvotes();
    }

    // Find the user's vote for this answer
    public function userVote(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->first();
    }

    // Count code blocks for this answer
    public function codeBlocks()
    {
        return $this->hasMany(CodeBlock::class);
    }
}
