@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    <main class="p-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6 text-black">
                <h2 class="text-xl font-bold text-[#1B1833] mb-4">Edit Your Answer</h2>
                
                <form action="{{ route('answer.update', $answer->id) }}" method="POST" class="answer-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <textarea name="content" rows="4" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7AE2CF]" placeholder="Write your answer here...">{{ $answer->content }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Tag for Code Block</label>
                        <select id="tagSelect" class="select2-tags form-control w-full">
                            <option value="">Select a tag...</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" data-tag-name="{{ $tag->name }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="code-blocks-container" class="space-y-4">
                        @if($answer->code_blocks)
                            @foreach(json_decode($answer->code_blocks, true) as $block)
                                <div class="code-block border rounded-lg p-4 mb-4" data-tag-id="{{ $block['tag_id'] }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="text-sm font-medium text-gray-700">Code for {{ $tags->find($block['tag_id'])->name }}</label>
                                        <button type="button" onclick="removeCodeBlock(this)" class="text-red-500 hover:text-red-700">Remove</button>
                                    </div>
                                    <textarea name="code_blocks[{{ $block['tag_id'] }}]" rows="6" class="code-content w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7AE2CF] font-mono">{{ $block['code'] }}</textarea>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <input type="hidden" name="tag_codes" id="tagCodesInput">
                    
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('question.show', $question->id) }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Answer</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/answer-edit.js') }}"></script>
@endpush
@endsection
