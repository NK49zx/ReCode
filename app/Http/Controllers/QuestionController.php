<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display the question form.
     */
    public function create()
    {
        // Restrict timed-out users from creating questions
        $user = auth()->user();
        if ($user && !$user->is_active) {
            return redirect()->route('dashboard')->with('error', 'You are not allowed to create a question at this time.');
        }

        // Get the latest questions with their users
        $questions = Question::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Get the most viewed questions
        $popularQuestions = Question::with('user')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();
            
        $tags = Tag::all();
        return view('question', compact('questions', 'popularQuestions', 'tags'));
    }

    //public function create()
    //{
    //    return view('question');
    //}

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'context' => 'required|string',
            'alt_content' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $question = Question::create([
            'title' => $validated['title'],
            'context' => $validated['context'],
            'alt_content' => $validated['alt_content'] ?? null,
            'user_id' => auth()->id(),
            'is_answered' => false,
            'views' => 0
        ]);

        if (isset($validated['tags'])) {
            $question->tags()->sync($validated['tags']);
        }

        return redirect()->route('dashboard');

    }

    // Show a specific question and its answers
    public function show($id)
    {
        $question = Question::with(['answers.user', 'user', 'tags'])
            ->findOrFail($id);
            
        // Increment view count
        $question->increment('views');
        
        // Get popular questions for sidebar
        $popularQuestions = Question::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        $tags = Tag::all();
        return view('answer', compact('question', 'tags', 'popularQuestions'));
    }

    // Redirects to edit questions page
    public function edit(Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403);
        }

       // Get popular questions for sidebar
        $tags = Tag::all();
        $popularQuestions = Question::with('user')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        return view('questions.edit', compact('question', 'tags', 'popularQuestions'));
    }

    // Handles updating questions
    public function update(Request $request, Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'context' => 'required|string',
            'alt_content' => 'nullable|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $question->update([
            'title' => $validated['title'],
            'context' => $validated['context'],
            'alt_content' => $validated['alt_content'] ?? null,
        ]);

        if (isset($validated['tags'])) {
            $question->tags()->sync($validated['tags']);
        }

        return redirect()->route('question.show', $question->id)
            ->with('success', 'Question updated successfully');
    }

    // Delete question threads
    public function destroy(Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403);
        }

        // Delete associated answers and code blocks
        foreach ($question->answers as $answer) {
            $answer->codeBlocks()->delete();
            $answer->delete();
        }

        // Delete the question
        $question->delete();

        return redirect()->route('dashboard');
    }

    // Show all questions according to filter
    public function index()
    {
        $query = Question::with(['user', 'tags', 'answers']);

        // Handle filter
        $filter = request('filter', 'newest');
        switch ($filter) {
            case 'most-viewed':
                $query->orderBy('views', 'desc');
                break;
            case 'answered':
                $query->has('answers');
                break;
            default: // 'newest'
                $query->latest();
        }

        // Handle tag filter
        if (request()->has('tag')) {
            $query->whereHas('tags', function($q) {
                $q->where('tags.id', request('tag'));
            });
        }
        $questions = $query->paginate(10);

        // Get popular questions for sidebar
        $tags = Tag::all();
        $popularQuestions = Question::withCount('answers')
                               ->orderBy('views', 'desc')
                               ->take(5)
                               ->get();

        return view('dashboard', compact('questions', 'tags', 'popularQuestions'));
    }
}
