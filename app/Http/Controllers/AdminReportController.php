<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    // List all reports
    public function index()
    {
        $reports = Report::with(['reporter', 'reportedUser', 'question', 'answer'])->latest()->paginate(20);
        return view('admin.reports.index', compact('reports'));
    }

    // Show a single report
    public function show($id)
    {
        $report = Report::with(['reporter', 'reportedUser', 'question', 'answer'])->findOrFail($id);
        return view('admin.reports.display', compact('report'));
    }

    // Update report status
    public function process(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $request->validate([
            'status' => 'required|in:reviewed,resolved,rejected',
            'admin_notes' => 'nullable|string',
        ]);
        $report->status = $request->status;
        $report->admin_notes = $request->admin_notes;
        $report->save();
        return redirect()->route('admin.reports.index')->with('success', 'Report processed.');
    }

    // Ban a user
    public function banUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->remember_token = null; // Force logout all sessions
        $user->save();
        return redirect()->back()->with('success', 'User has been banned, deactivated, and logged out.');
    }

    // Unban a user
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->save();
        return redirect()->back()->with('success', 'User has been unbanned and privileges restored.');
    }
}
