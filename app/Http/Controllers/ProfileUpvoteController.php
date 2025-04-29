<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileUpvoteController extends Controller
{
    // Show the logged-in user's upvoted questions
    public function index()
    {
        $upvotedQuestions = auth()->user()
            ->questionVotes()
            ->where('type', 'upvote')
            ->with(['question.tags', 'question.user'])
            ->latest()
            ->paginate(10)
            ->through(fn($vote) => $vote->question);

        return view('profile.upvoted', compact('upvotedQuestions'));
    }
}
