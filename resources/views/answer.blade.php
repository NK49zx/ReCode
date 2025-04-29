@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    
    <div class="flex gap-8 p-10">
        <!-- Left Sidebar -->
        @include('components.left-sidebar')

        <!-- Main Content -->
        <div class="flex-1 max-w-4xl">
            <!-- Question Section -->
            <div class="flex gap-4 mb-6">

                <!-- Question Content -->
                <div class="bg-white rounded-lg shadow-lg p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-2xl font-bold text-[#FF6500]">{{ $question->title }}</h1>
                        @auth
                            @if(auth()->id() === $question->user_id)
                                <div class="flex gap-2 mb-2">
                                    <a href="{{ route('question.edit', $question->id) }}" class="btn btn-sm btn-neutral">Edit</a>
                                    <form action="{{ route('question.destroy', $question->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error">Delete</button>
                                    </form>
                                </div>
                            @endif
                            <!-- Report actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('report.create', ['type' => 'user', 'user_id' => $question->user_id]) }}" class="btn btn-xs btn-error">Report User</a>
                                <a href="{{ route('report.create', ['type' => 'question', 'question_id' => $question->id]) }}" class="btn btn-xs btn-warning">Report Question</a>
                            </div>
                        @endauth
                    </div>

                    <div class="mb-4">
                        <p class="text-gray-700">{{ $question->context }}</p>
                    </div>

                    @if($question->tags->count() > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($question->tags as $tag)
                                <span class="badge badge-primary">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <div>
                            Asked by <span class="text-[#7AE2CF]">{{ $question->user->username }}</span>
                            <span class="mx-2">•</span>
                            {{ $question->created_at->diffForHumans() }}
                        </div>
                        <div class="flex items-center gap-2">
                            <span>{{ $question->views }} views</span>
                            <span class="mx-2">•</span>
                            <span>{{ $question->answers->count() }} answers</span>
                            <span class="mx-2">•</span>
                            @auth
                                @if(auth()->user()->bookmarkedQuestions()->where('question_id', $question->id)->exists())
                                    <form action="{{ route('question.unbookmark', $question->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('question.bookmark', $question->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z" />
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Voting Controls for Question -->
                <div class="flex flex-col justify-center items-center gap-3 bg-white p-4 rounded-lg shadow-lg">
                    @auth
                        @if(auth()->id() === $question->user_id)
                            <!-- Disabled buttons for question author -->
                            <button disabled class="btn btn-sm opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span class="font-bold text-black">{{ $question->voteScoreQ() }}</span>
                            <button disabled class="btn btn-sm opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <form action="{{ route('question_vote.upvote', $question) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $question->userVoteQ(auth()->user())?->type === 'upvote' ? 'btn-success' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                            <span class="font-bold text-black">{{ $question->voteScoreQ() }}</span>
                            <form action="{{ route('question_vote.downvote', $question) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $question->userVoteQ(auth()->user())?->type === 'downvote' ? 'btn-error' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <span class="font-bold text-black">{{ $question->voteScore() }}</span>
                        <a href="{{ route('login') }}" class="btn btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>

            @if($question->alt_content)
            <h1>Provided Code</h1>
                <div class="mt-2 mb-4 bg-gray-500 rounded-lg shadow-lg p-6">
                    <code class="text-sm text-white block">{{ $question->alt_content }}</code>
                </div>
            @endif

            <!-- Answer Form (Unavailable to the question author) -->
            @auth
                @if(auth()->id() !== $question->user_id)
                    <div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-black">
                        <h2 class="text-xl font-bold text-[#1B1833] mb-4">Your Answer</h2>
                        <form action="{{ route('answer.store', $question->id) }}" method="POST" class="answer-form">
                            @csrf
                            <div class="mb-4">
                                <textarea name="content" rows="2" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7AE2CF]" placeholder="Write your answer here..."></textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Tag for Code Block</label>
                                <select id="tagSelect" class="select2 form-control w-full" >
                                    <option value="">Select a tag...</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" data-tag-name="{{ $tag->name }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="code-blocks-container" class="space-y-4">
                            </div>

                            <input type="hidden" name="tag_codes" id="tagCodesInput">
                            <button type="submit" class="btn btn-primary mt-4">Post Answer</button>
                        </form>
                    </div>
                    @push('scripts')
                    <script src="{{ asset('js/answer-form.js') }}"></script>
                    @endpush
                @endif
            @endauth

            <!-- Answers Section -->
            <div class="space-y-6">
                <div class="flex justify-between items-center text-center">
                    <h2 class="text-xl font-bold">{{ $question->answers->count() }} Answers</h2>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Login to Answer
                        </a>
                    @endguest
                </div>
                
                @forelse($question->answers as $answer)
                    <div class="flex gap-4">
                        <!-- Answer Content -->
                        <div class="bg-white rounded-lg shadow-lg p-6 text-black flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex flex-col gap-2">
                                    <p class="text-gray-700">{{ $answer->content }}</p>
                                </div>
                                @if($answer->is_accepted)
                                    <span class="badge badge-success">Accepted Answer</span>
                                @endif
                                @auth
                                    <!-- Report actions -->
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('report.create', ['type' => 'user', 'user_id' => $answer->user_id]) }}" class="btn btn-xs btn-error">Report User</a>
                                        <a href="{{ route('report.create', ['type' => 'answer', 'answer_id' => $answer->id]) }}" class="btn btn-xs btn-warning">Report Answer</a>
                                    </div>
                                @endauth
                            </div>

                            @if($answer->codeBlocks->count() > 0)
                                @foreach($answer->codeBlocks as $codeBlock)
                                    <div class="flex justify-between items-center mt-4 text-white">
                                        <span class="badge badge-info">{{ $codeBlock->tag->name }}</span>
                                    </div>
                                    <div class="mt-2 bg-gray-500 rounded-lg shadow-lg p-6">
                                        <code class="text-sm text-white block">{{ $codeBlock->code }}</code>
                                    </div>
                                @endforeach
                            @endif

                            <div class="flex justify-between items-center text-sm text-gray-500 mt-4">
                                <div>
                                    Answered by <span class="text-[#7AE2CF]">{{ $answer->user->username }}</span>
                                    <span class="mx-2">•</span>
                                    {{ $answer->created_at->diffForHumans() }}
                                </div>
                                <div class="flex items-center gap-2">
                                    @auth
                                        @if(auth()->id() === $question->user_id && !$answer->is_accepted)
                                            <form action="{{ route('answer.accept', $answer->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Accept Answer</button>
                                            </form>
                                        @endif
                                        @if(auth()->id() === $answer->user_id)
                                            <div class="flex gap-2">
                                                <a href="{{ route('answer.edit_external', $answer->id) }}" class="btn btn-sm btn-neutral">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('answer.destroy', $answer->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this answer?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-error">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- Voting Controls -->
                        <div class="flex flex-col justify-center items-center gap-3 bg-white p-4 rounded-lg shadow-lg">
                            @auth
                                @if(auth()->id() === $answer->user_id)
                                    <!-- Disabled buttons for answer author -->
                                    <button disabled class="btn btn-sm opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <span class="font-bold text-black">{{ $answer->voteScore() }}</span>
                                    <button disabled class="btn btn-sm opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @else
                                    <form action="{{ route('answer.upvote', $answer->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $answer->userVote(auth()->user())?->type === 'upvote' ? 'btn-success' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    <span class="font-bold text-black">{{ $answer->voteScore() }}</span>
                                    <form action="{{ route('answer.downvote', $answer->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $answer->userVote(auth()->user())?->type === 'downvote' ? 'btn-error' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 0 01-1.414-1.414l4-4a1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <span class="font-bold text-black">{{ $answer->voteScore() }}</span>
                                <a href="{{ route('login') }}" class="btn btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 0 111.414 1.414l-4 4a1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                        <p class="text-gray-500">No answers yet. Be the first to answer this question!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Sidebar -->
        @include('components.sidebar')
    </div>
</div>
@endsection