<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileAnswerController extends Controller
{
    // Show the logged-in user's answer
    public function index()
    {
        $answers = auth()->user()->answers()
            ->with(['question', 'question.tags'])
            ->latest()
            ->paginate(10);

        return view('profile.answers', compact('answers'));
    }
}
