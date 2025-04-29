@extends('layouts.main')

@section('content')
@include('layouts.navigation')
<div class="flex min-h-[calc(100vh-5rem)] bg-[#18162c]">
    <aside class="w-64 bg-[#1B1833] text-white flex flex-col p-6 gap-6 min-h-full">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">User Data</a>
            <a href="{{ route('admin.analytics.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Analytics</a>
            <a href="{{ route('admin.questions.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a] bg-[#23204a]">Manage Questions</a>
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Manage Questions</h1>
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
                        <th class="py-2 px-4">Title</th>
                        <th class="py-2 px-4">User</th>
                        <th class="py-2 px-4">Answer Status</th>
                        <th class="py-2 px-4">Answers</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($questions as $question)
                    <tr class="border-b text-center">
                        <td class="py-2 px-4">{{ $question->id }}</td>
                        <td class="py-2 px-4">{{ $question->title }}</td>
                        <td class="py-2 px-4">
                            @if($question->user)
                                <a href="{{ route('admin.users.edit', $question->user->id) }}" class="text-blue-700 hover:underline">{{ $question->user->name }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            @if($question->answers->where('is_accepted', true)->count())
                                <span class="text-green-600 font-semibold">Accepted</span>
                            @else
                                <span class="text-red-600 font-semibold">Not accepted</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $question->answers->count() }}</td>
                        <td class="py-2 px-4 flex gap-2 justify-center">
                            <a href="{{ route('question.show', $question->id) }}" class="text-blue-600 hover:underline" target="_blank">View</a>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $questions->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
