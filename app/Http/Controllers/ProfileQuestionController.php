<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileQuestionController extends Controller
{
    // Show the logged-in user's questions
    public function index()
    {
        $questions = auth()->user()->questions()
            ->with(['tags', 'user'])
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return view('profile.questions', compact('questions'));
    }
}
