<div class="">
    <main class="p-10 mb-6 flex flex-col lg:flex-row gap-8">
        @include('components.left-sidebar')
        <div class="flex flex-col gap-4 border border-white rounded-lg p-4 w-full lg:w-4/5">
            <div class="flex justify-between">
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl">Questions of the day</h1>
                    
                </div>
                @auth
                    <a href="{{ route('question.create') }}" class="btn btn-warning text-xl">Ask Question</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning text-xl">Ask Question</a>
                @endauth
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex gap-2 border border-white w-fit rounded-lg p-2">
                    <a href="{{ route('dashboard', ['filter' => 'newest']) }}" 
                       class="btn btn-sm {{ request('filter') == 'newest' ? 'btn-primary' : 'btn-ghost' }}">
                        Newest
                    </a>
                    <a href="{{ route('dashboard', ['filter' => 'most-viewed']) }}"
                       class="btn btn-sm {{ request('filter') == 'most-viewed' ? 'btn-primary' : 'btn-ghost' }}">
                        Most Viewed
                    </a>
                    <a href="{{ route('dashboard', ['filter' => 'answered']) }}"
                       class="btn btn-sm {{ request('filter') == 'answered' ? 'btn-primary' : 'btn-ghost' }}">
                        Answered
                    </a>
                </div>
                <div>
                    <span class="text-white text-xl">{{ $questions->total() }} questions</span>
                </div>
            </div>

            <div class="mt-4 mb-4">
                <button id="toggle-tags-btn" type="button" class="flex items-center gap-2 text-white hover:text-[#FF6500]">
                    <i id="toggle-tags-icon" class="fas fa-chevron-right"></i>
                    <span>Filter by tags</span>
                    <span class="text-sm text-gray-400">({{ $tags->count() }})</span>
                </button>
                <div id="tags-panel" style="display:none;" class="flex flex-wrap gap-2 mt-3">
                    <a href="{{ route('dashboard') }}" 
                       class="badge {{ !request('tag') ? 'badge-primary' : 'badge-outline hover:bg-[#2A2649]' }}">
                        All Tags
                    </a>
                    @foreach($tags as $tag)
                        <a href="{{ route('dashboard', ['tag' => $tag->id]) }}" 
                           class="badge {{ request('tag') == $tag->id ? 'badge-primary' : 'badge-outline hover:bg-[#2A2649]' }}">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if($questions->count() > 0)
                @foreach($questions as $question)
                    <div class="card card-border bg-white w-full ">
                        <div class="card-body bg-white">
                            <div class="flex justify-between items-start">
                                <h2 class="card-title text-[#FF6500] text-2xl">{{ $question->title }}</h2>
                                @auth
                                    @if(auth()->user()->bookmarkedQuestions()->where('question_id', $question->id)->exists())
                                        <form action="{{ route('question.unbookmark', $question->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn px-5 btn-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('question.bookmark', $question->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"  class="btn btn-active btn-secondary px-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-active btn-secondary px-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 19V5z" />
                                        </svg>
                                    </a>
                                @endauth
                            </div>
                            <p class="text-gray-500 text-sm">{{ Str::limit($question->context, 150) }}</p>
                            
                            @if($question->tags->count() > 0)
                                <div class="flex flex-wrap gap-2 text-black">
                                    @foreach($question->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    Asked by<span class="p-1 rounded-md text-red-500">{{ $question->user->username }}</span>
                                </div>
                                
                                <div class="card-actions justify-end flex items-center gap-4">
                                    <div class="flex gap-4 text-sm text-gray-500">  
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-arrow-up"></i>
                                            <span>{{ $question->voteScoreQ() }} votes</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-comment"></i>
                                            <span>{{ $question->answers->count() ?? 0 }} answers</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $question->views ?? 0 }} views</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('question.show', $question->id) }}"><button class="btn btn-primary">View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card card-border bg-base-100 w-full">
                    <div class="card-body">
                        <h2 class="card-title text-black">No questions yet</h2>
                        <p class="text-black">Be the first to ask a question!</p>
                    </div>
                </div>
            @endif
        </div>

        @include('components.sidebar')
    </main>
    @push('scripts')
<script src="{{ asset('js/tags-toggle.js') }}"></script>
@endpush
</div>