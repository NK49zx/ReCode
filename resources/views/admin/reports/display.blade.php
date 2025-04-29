@extends('layouts.main')

@section('content')
@include('layouts.navigation')
<div class="flex min-h-[calc(100vh-5rem)] bg-[#18162c]">
    <aside class="w-64 bg-[#1B1833] text-white flex flex-col p-6 gap-6 min-h-full">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">User Data</a>
            <a href="{{ route('admin.analytics.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Analytics</a>
            <a href="{{ route('admin.questions.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Manage Questions</a>
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a] bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Report Details</h1>
        <div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
            <div class="mb-4">
                <strong>Type:</strong> {{ ucfirst($report->type) }}<br>
                <strong>Reporter:</strong> {{ $report->reporter->name ?? 'N/A' }}<br>
                <strong>Reported:</strong>
                @if($report->type === 'user')
                    {{ $report->reportedUser->name ?? 'N/A' }}
                @elseif($report->type === 'question')
                    Q#{{ $report->question_id }}
                    @if($report->question)
                        - <span class="text-gray-700">{{ $report->question->title }}</span>
                    @endif
                    <a href="{{ route('question.show', $report->question_id) }}" class="text-blue-600 hover:underline ml-2" target="_blank">View Thread</a>
                    @if($report->question && $report->question->user)
                        <span class="ml-2 text-gray-500">by {{ $report->question->user->name }}</span>
                    @endif
                @elseif($report->type === 'answer')
                    A#{{ $report->answer_id }}
                    @if($report->answer && $report->answer->user)
                        <span class="ml-2 text-gray-500">by {{ $report->answer->user->name }}</span>
                    @endif
                @endif<br>
                <strong>Reason:</strong> {{ $report->reason }}<br>
                <strong>Status:</strong> {{ ucfirst($report->status) }}<br>
                <strong>Submitted:</strong> {{ $report->created_at->diffForHumans() }}<br>
            </div>
            <form action="{{ route('admin.reports.process', $report->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded p-2">
                        <option value="reviewed" @if($report->status=='reviewed') selected @endif>Reviewed</option>
                        <option value="resolved" @if($report->status=='resolved') selected @endif>Resolved</option>
                        <option value="rejected" @if($report->status=='rejected') selected @endif>Rejected</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Admin Notes</label>
                    <textarea name="admin_notes" rows="3" class="w-full border rounded p-2">{{ $report->admin_notes }}</textarea>
                </div>
                <button type="submit" class="bg-[#FF6500] text-white px-4 py-2 rounded hover:bg-[#e65c00]">Update Report</button>
            </form>
            <div class="flex gap-4 mt-4">
                @if($report->reportedUser)
                    @if($report->reportedUser->is_active)
                        <form action="{{ route('admin.reports.banUser', $report->reportedUser->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to ban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ban & Deactivate User</button>
                        </form>
                    @else
                        <form action="{{ route('admin.reports.unbanUser', $report->reportedUser->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Unban & Restore User</button>
                        </form>
                    @endif
                @elseif($report->type === 'question' && $report->question && $report->question->user)
                    @if($report->question->user->is_active)
                        <form action="{{ route('admin.reports.banUser', $report->question->user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to ban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ban & Deactivate Author</button>
                        </form>
                    @else
                        <form action="{{ route('admin.reports.unbanUser', $report->question->user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Unban & Restore Author</button>
                        </form>
                    @endif
                @elseif($report->type === 'answer' && $report->answer && $report->answer->user)
                    @if($report->answer->user->is_active)
                        <form action="{{ route('admin.reports.banUser', $report->answer->user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to ban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ban & Deactivate Author</button>
                        </form>
                    @else
                        <form action="{{ route('admin.reports.unbanUser', $report->answer->user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unban this user?');" style="display:inline;">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Unban & Restore Author</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
