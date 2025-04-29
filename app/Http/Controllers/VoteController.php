<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller for Answer voting
class VoteController extends Controller
{
    public function upvote(Answer $answer)
    {
        $user = Auth::user();
        
        // Check if user is voting on their own answer
        if ($answer->user_id === $user->id) {
            return back();
        }

        $existingVote = $answer->userVote($user);

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
        Vote::create([
            'user_id' => $user->id,
            'answer_id' => $answer->id,
            'type' => 'upvote'
        ]);

        return back();
    }

    public function downvote(Answer $answer)
    {
        $user = Auth::user();
        
        // Check if user is voting on their own answer
        if ($answer->user_id === $user->id) {
            return back();
        }

        $existingVote = $answer->userVote($user);

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
        Vote::create([
            'user_id' => $user->id,
            'answer_id' => $answer->id,
            'type' => 'downvote'
        ]);

        return back();
    }
} 