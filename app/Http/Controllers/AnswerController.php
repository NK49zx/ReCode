<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        //
    }

    // Show the form for creating a new resource
    public function create()
    {
        //
    }

    // Store a newly created resource in storage
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|min:10',
            'tag_codes' => 'nullable|json'
        ]);

        $answer = new Answer();
        $answer->content = $request->content;
        $answer->user_id = Auth::id();
        $answer->question_id = $question->id;
        $answer->save();

        // Handle tag-specific code blocks
        if ($request->tag_codes) {
            $tagCodes = json_decode($request->tag_codes, true);
            foreach ($tagCodes as $tagId => $code) {
                if (!empty($code)) {
                    $answer->codeBlocks()->create([
                        'tag_id' => $tagId,
                        'code' => $code
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Answer posted successfully!');
    }

    // Show the answer edit form
    public function editExternal(Answer $answer)
    {
        if (! \Gate::allows('update-answer', $answer)) {
            abort(403);
        }
        $tags = Tag::all();
        $question = $answer->question;
        return view('answers.edit_external', compact('answer', 'tags', 'question'));
    }

    // Update an answer
    public function update(Request $request, Answer $answer)
    {
        if (! Gate::allows('update-answer', $answer)) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|min:10',
            'tag_codes' => 'nullable|json'
        ]);

        $answer->content = $request->content;
        $answer->save();

        // Update code blocks
        if ($request->tag_codes) {
            // Remove existing code blocks
            $answer->codeBlocks()->delete();
            
            // Add new code blocks
            $tagCodes = json_decode($request->tag_codes, true);
            foreach ($tagCodes as $tagId => $code) {
                if (!empty($code)) {
                    $answer->codeBlocks()->create([
                        'tag_id' => $tagId,
                        'code' => $code
                    ]);
                }
            }
        }

        return redirect()->route('question.show', $answer->question_id)
                        ->with('success', 'Answer updated successfully!');
    }

    // Remove the specified resource from storage
    public function destroy(Answer $answer)
    {
        if (! Gate::allows('delete-answer', $answer)) {
            abort(403);
        }

        $questionId = $answer->question_id;
        $answer->delete();

        return redirect()->route('question.show', $questionId)
                        ->with('success', 'Answer deleted successfully!');
    }

    // Accept an answer
    public function accept(Answer $answer)
    {
        $question = $answer->question;
        if (! Gate::allows('accept-answer', [$answer, $question])) {
            abort(403);
        }

        // Remove accepted status from any previously accepted answer
        $question->answers()->where('is_accepted', true)->update(['is_accepted' => false]);

        $answer->is_accepted = true;
        $answer->save();

        return redirect()->back()->with('success', 'Answer marked as accepted!');
    }
}
