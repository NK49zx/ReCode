<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Show report form
    public function create(Request $request)
    {
        $type = $request->get('type');
        $question = $request->get('question_id') ? Question::find($request->get('question_id')) : null;
        $answer = $request->get('answer_id') ? Answer::find($request->get('answer_id')) : null;
        $user = $request->get('user_id') ? User::find($request->get('user_id')) : null;
        $currentUser = Auth::user();

        // Prevent self-reporting
        if (($type === 'user' && $user && $user->id === $currentUser->id) ||
            ($type === 'question' && $question && $question->user_id === $currentUser->id) ||
            ($type === 'answer' && $answer && $answer->user_id === $currentUser->id)) {
            return redirect()->back();
        }

        return view('report.create', compact('type', 'question', 'answer', 'user'));
    }

    // Store report
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:user,question,answer',
            'reason' => 'required|string|max:1000',
            'question_id' => 'nullable|exists:questions,id',
            'answer_id' => 'nullable|exists:answers,id',
            'user_id' => 'nullable|exists:users,id',
        ]);
        $currentUser = Auth::user();

        $report = Report::create([
            'reporter_id' => $currentUser->id,
            'reported_user_id' => $data['user_id'] ?? null,
            'question_id' => $data['question_id'] ?? null,
            'answer_id' => $data['answer_id'] ?? null,
            'type' => $data['type'],
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);
        // Redirect to question thread
        if (!empty($data['question_id']) || !empty($data['answer_id']) || !empty($data['user_id'])) {
            return redirect()->route('question.show', $data['question_id'] ?? $data['answer_id'] ?? $data['user_id']);
        }
        return redirect()->back();
    }
}
