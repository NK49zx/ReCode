@extends('layouts.main')

@section('content')
@include('layouts.navigation')
<div class="flex min-h-[calc(100vh-5rem)] bg-[#18162c]">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#1B1833] text-white flex flex-col p-6 gap-6 min-h-full">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">User Data</a>
            <a href="{{ route('admin.analytics.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Analytics</a>
            <a href="{{ route('admin.questions.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Manage Questions</a>
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Admin Dashboard</h1>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-lg text-gray-700">Welcome, Admin!</p>
        </div>
    </main>
</div>
@endsection
