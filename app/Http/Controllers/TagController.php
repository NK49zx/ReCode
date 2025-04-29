<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Handles tag search and display for tags page
    public function index(Request $request)
    {
        $query = Tag::withCount('questions');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $sort = $request->sort ?? 'popular';
        switch ($sort) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderByDesc('questions_count');
        }

        $tags = $query->paginate(20);

        return view('tags.index', compact('tags'));
    }

    // Handles tag display for tag page
    public function show(Tag $tag)
    {
        $questions = $tag->questions()
            ->with(['user', 'tags'])
            ->withCount('answers')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tags.show', compact('tag', 'questions'));
    }
}
