@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    @include('profile.partials.profile-navigation')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="p-6 text-black">
                    <h2 class="text-2xl font-bold mb-4 border-b border-black py-2">Your Questions</h2>
                    @forelse($questions as $question)
                        <div class="border-b border-gray-200 py-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('question.show', $question->id) }}" class="text-lg font-semibold hover:text-[#FF6500]">
                                        {{ $question->title }}
                                    </a>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                        <span>{{ $question->answers_count }} answers</span>
                                        <span>{{ $question->views }} views</span>
                                        @foreach($question->tags as $tag)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    Asked {{ $question->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">You haven't asked any questions yet.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
