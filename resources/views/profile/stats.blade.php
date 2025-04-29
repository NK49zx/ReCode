@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    @include('profile.partials.profile-navigation')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6 text-black">
                    <h2 class="text-2xl font-bold mb-6">Activity Statistics</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Questions Stats -->
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Questions</h3>
                            <p class="text-3xl text-[#FF6500]">{{ $stats['total_questions'] }}</p>
                            <p class="text-sm text-gray-600">{{ $stats['questions_with_answers'] }} with answers</p>
                        </div>

                        <!-- Answers Stats -->
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Answers</h3>
                            <p class="text-3xl text-[#48CFCB]">{{ $stats['total_answers'] }}</p>
                            <p class="text-sm text-gray-600">{{ $stats['accepted_answers'] }} accepted</p>
                        </div>

                        <!-- Engagement Stats -->
                        <div class="bg-gray-200 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-2">Engagement</h3>
                            <p class="text-3xl text-[#FF6500]">{{ $stats['total_upvotes'] }}</p>
                            <p class="text-sm text-gray-600">{{ $stats['total_bookmarks'] }} bookmarks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
