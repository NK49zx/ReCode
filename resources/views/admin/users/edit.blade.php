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
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <main class="flex-1 p-8 items-center">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Edit User</h1>
        <div class="bg-white shadow rounded-lg p-6 w-full">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Admin</label>
                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}> Is Admin
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Active</label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}> Is Active
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-[#FF6500] text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
                </div>
            </form>
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-2 text-[#23204a]">Questions by this user</h2>
                @if($user->questions->count())
                    <ul class="list-disc ml-6">
                        @foreach($user->questions as $question)
                            <li>
                                <a href="{{ url('/question/' . $question->id) }}" class="text-blue-600 hover:underline" target="_blank">{{ $question->title }}</a>
                                <span class="text-xs text-gray-500">({{ $question->answers->count() }} answers)</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No questions found for this user.</p>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
