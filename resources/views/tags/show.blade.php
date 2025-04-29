@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    
    <div class="flex">
        <div class="p-10 mt-16">
            @include('components.left-sidebar')
        </div>
        
        <main class="flex-1 p-10 pl-0">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl flex items-center gap-3">
                            <span class="text-[#FF6500]">#{{ $tag->name }}</span>
                        </h1>
                        <p class="text-gray-400 mt-2">{{ $questions->total() }} questions</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($questions as $question)
                        <div class="bg-[#2A2649] p-6 rounded-lg">
                            <a href="{{ route('question.show', $question) }}" class="text-xl font-semibold hover:text-[#FF6500]">
                                {{ $question->title }}
                            </a>
                            <div class="flex items-center gap-4 mt-2 text-sm text-gray-400">
                                <span>{{ $question->answers_count }} answers</span>
                                <span>{{ $question->views }} views</span>
                                <span>Asked by {{ $question->user->username }}</span>
                                <span>{{ $question->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $questions->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
