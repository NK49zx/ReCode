<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index(Request $request)
    {
        $query = Question::with(['user', 'tags', 'answers']);

        // Apply tag filter
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // Apply sorting/filter options
        switch ($request->get('filter')) {
            case 'most-viewed':
                $query->orderBy('views', 'desc');
                break;
            case 'answered':
                $query->has('answers');
                break;
            default:
                $query->latest();
        }

        // Paginate questions and get tags/popular questions
        $questions = $query->paginate(10);
        $tags = Tag::orderBy('name')->get();
        $popularQuestions = Question::orderBy('views', 'desc')->take(5)->get();

        return view('dashboard', compact('questions', 'popularQuestions', 'tags'));
    }
}
