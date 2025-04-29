@extends('layouts.main')

@section('content')
@include('layouts.navigation')
<div class="flex min-h-[calc(100vh-5rem)] bg-[#18162c]">
    <aside class="w-64 bg-[#1B1833] text-white flex flex-col p-6 gap-6 min-h-full">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a] bg-[#23204a]">User Data</a>
            <a href="{{ route('admin.analytics.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Analytics</a>
            <a href="{{ route('admin.questions.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Manage Questions</a>
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Manage Users</h1>
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
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Bio</th>
                        <th class="py-2 px-4">Admin</th>
                        <th class="py-2 px-4">Active</th>
                        <th class="py-2 px-4">Questions</th>
                        <th class="py-2 px-4">Answers</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="border-b text-center align-top">
                        <td class="py-2 px-4">{{ $user->id }}</td>
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4">{{ $user->bio }}</td>
                        <td class="py-2 px-4">{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                        <td class="py-2 px-4">{{ $user->is_active ? 'Yes' : 'No' }}</td>
                        <td class="py-2 px-4"><span class="font-bold">{{ $user->questions->count() }}</span></td>
                        <td class="py-2 px-4"><span class="font-bold">{{ $user->answers->count() }}</span></td>
                        <td class="py-2 px-4 flex gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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
                {{ $users->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
