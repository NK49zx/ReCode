<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileStatsController extends Controller
{
    // Show the logged-in user's stats
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_questions' => $user->questions()->count(),
            'total_answers' => $user->answers()->count(),
            'total_upvotes' => $user->questionVotes()->where('type', 'upvote')->count(),
            'total_bookmarks' => $user->bookmarkedQuestions()->count(),
            'accepted_answers' => $user->answers()->where('is_accepted', true)->count(),
            'questions_with_answers' => $user->questions()->has('answers')->count(),
        ];

        return view('profile.stats', compact('stats'));
    }
}
