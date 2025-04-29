<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    //Add bookmark
    public function store(Question $question)
    {
        $user = Auth::user();
        
        if (!$user->bookmarkedQuestions()->where('question_id', $question->id)->exists()) {
            $user->bookmarkedQuestions()->attach($question->id);
            return back()->with('success', 'Question bookmarked successfully!');
        }
        
        return back()->with('info', 'Question already bookmarked!');
    }

    //Remove bookmark
    public function destroy(Question $question)
    {
        $user = Auth::user();
        $user->bookmarkedQuestions()->detach($question->id);
        
        return back()->with('success', 'Question unbookmarked successfully!');
    }
} 