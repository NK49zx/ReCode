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
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Reports</h1>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-[#23204a] text-white">
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Type</th>
                        <th class="py-2 px-4">Reporter</th>
                        <th class="py-2 px-4">Reported</th>
                        <th class="py-2 px-4">Reason</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr class="border-b text-center">
                        <td class="py-2 px-4">{{ $report->id }}</td>
                        <td class="py-2 px-4">{{ ucfirst($report->type) }}</td>
                        <td class="py-2 px-4">{{ $report->reporter->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4">
                            @if($report->type === 'user')
                                {{ $report->reportedUser->name ?? 'N/A' }}
                            @elseif($report->type === 'question')
                                Q#{{ $report->question_id }}
                            @elseif($report->type === 'answer')
                                A#{{ $report->answer_id }}
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ Str::limit($report->reason, 40) }}</td>
                        <td class="py-2 px-4">{{ ucfirst($report->status) }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.reports.display', $report->id) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
