@extends('layouts.main')

@section('content')
@include('layouts.navigation')
<div class="flex min-h-[calc(100vh-5rem)] bg-[#18162c]">
    <aside class="w-64 bg-[#1B1833] text-white flex flex-col p-6 gap-6 min-h-full">
        <h2 class="text-xl font-bold mb-4">Admin Panel</h2>
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.users.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">User Data</a>
            <a href="{{ route('admin.analytics.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a] bg-[#23204a]">Analytics</a>
            <a href="{{ route('admin.questions.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Manage Questions</a>
            <a href="{{ route('admin.reports.index') }}" class="py-2 px-3 rounded hover:bg-[#23204a]">Reports</a>
        </nav>
    </aside>
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6 text-[#FF6500]">Analytics Overview</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-2xl font-bold text-[#FF6500]">{{ $totalUsers }}</div>
                <div class="text-gray-600">Total Users</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-2xl font-bold text-[#FF6500]">{{ $totalQuestions }}</div>
                <div class="text-gray-600">Total Questions</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-2xl font-bold text-[#FF6500]">{{ $answeredQuestions }}</div>
                <div class="text-gray-600">Questions Answered</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <div class="text-2xl font-bold text-[#FF6500]">{{ $totalAnswers }}</div>
                <div class="text-gray-600">Total Answers</div>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center col-span-1 md:col-span-2 lg:col-span-1">
                <div class="text-lg font-semibold mb-2 text-[#23204a]">Popular Tags</div>
                <ul>
                    @foreach($popularTags as $tag)
                        <li class="mb-1"><span class="font-bold">{{ $tag->name }}</span> ({{ $tag->questions_count }} questions)</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-[#23204a]">User Registrations (Last 14 Days)</h2>
            <canvas id="userRegistrationsChart" height="80"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('userRegistrationsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Registrations',
                        data: @json($data),
                        fill: true,
                        borderColor: '#FF6500',
                        backgroundColor: 'rgba(255,101,0,0.1)',
                        tension: 0.4,
                        pointBackgroundColor: '#FF6500',
                        pointBorderColor: '#FF6500',
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    </main>
</div>
@endsection
