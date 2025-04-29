<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    // Display a paginated list of questions with related user and answers
    public function index()
    {
        $questions = Question::with(['user', 'answers'])->latest()->paginate(15);
        return view('admin.questions.index', compact('questions'));
    }

    // Show the edit form for a specific question
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }

    // Update a question's details
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);
        $question->update($request->only(['title', 'body', 'status']));
        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    // Delete a question
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}
