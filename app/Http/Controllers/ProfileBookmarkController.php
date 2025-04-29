<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileBookmarkController extends Controller
{
    // Show the logged-in user's bookmarks
    public function index()
    {
        $bookmarks = auth()->user()
            ->bookmarkedQuestions()
            ->with(['tags', 'user'])
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return view('profile.bookmarks', compact('bookmarks'));
    }
}
