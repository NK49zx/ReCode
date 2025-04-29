<?php

namespace App\Http\Controllers;

use App\Models\question;
use App\Models\QuestionVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionVoteController extends Controller
{
    public function upvote(Question $question)
    {
        $user = Auth::user();
        
        // Check if user is voting on their own question
        if ($question->user_id === $user->id) {
            return back();
        }

        $existingVote = $question->userVoteQ($user);

        if ($existingVote) {
            if ($existingVote->type === 'upvote') {
                // If already upvoted, remove the vote
                $existingVote->delete();
                return back();
            } else {
                // If downvoted, change to upvote
                $existingVote->update(['type' => 'upvote']);
                return back();
            }
        }

        // Create new upvote
        QuestionVote::create([
            'user_id' => $user->id,
            'question_id' => $question->id,
            'type' => 'upvote'
        ]);

        return back();
    }

    public function downvote(question $question)
    {
        $user = Auth::user();
        
        // Check if user is voting on their own question
        if ($question->user_id === $user->id) {
            return back();
        }

        $existingVote = $question->userVoteQ($user);

        if ($existingVote) {
            if ($existingVote->type === 'downvote') {
                // If already downvoted, remove the vote
                $existingVote->delete();
                return back();
            } else {
                // If upvoted, change to downvote
                $existingVote->update(['type' => 'downvote']);
                return back();
            }
        }

        // Create new downvote
        QuestionVote::create([
            'user_id' => $user->id,
            'question_id' => $question->id,
            'type' => 'downvote'
        ]);

        return back();
    }
} 