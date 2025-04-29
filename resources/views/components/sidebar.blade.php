<div class="text-black w-80 bg-base-100 rounded-lg shadow-lg p-4 h-fit sticky top-4">
    <h3 class="text-lg font-bold mb-4">Popular Threads</h3>
    <ul class="list bg-base-100 rounded-box w-full">
        @if($popularQuestions->count() > 0)
            @foreach($popularQuestions as $question)
                <li class="list-row hover:bg-base-200 p-2 rounded-lg transition-colors">
                    <div>
                        <div class="text-[#FF6500]">{{ $question->user->username }}</div>
                        <div class="text-xs uppercase font-semibold opacity-60">{{ Str::limit($question->title, 30) }}</div>
                    </div>
                </li>
            @endforeach
        @else
            <li class="p-2">
                <div class="text-sm text-gray-500">No popular questions yet</div>
            </li>
        @endif
    </ul>
</div>