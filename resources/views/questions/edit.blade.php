@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')

    <main class="p-10 mb-6 flex flex-col lg:flex-row gap-8">
        <div class="flex flex-col gap-4 border border-white rounded-lg p-4 w-full lg:w-4/5">
            <h1 class="text-3xl mb-6">Edit Question</h1>
            
            <form method="POST" action="{{ route('question.update', $question->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Title</span>
                    </label>
                    <input type="text" name="title" value="{{ $question->title }}" class="input input-bordered w-full text-black" required />
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Context</span>
                    </label>
                    <textarea name="context" class="textarea textarea-bordered h-32 text-black w-full" required>{{ $question->context }}</textarea>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Code</span>
                    </label>
                    <textarea name="alt_content" class="textarea textarea-bordered h-32 text-black w-full">{{ $question->alt_content }}</textarea>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text text-white">Tags</span>
                    </label> 
                    <select name="tags[]" class="select2 form-control w-full" multiple="multiple">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ $question->tags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end gap-4">
                    <a href="{{ route('question.show', $question->id) }}" class="btn">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Question</button>
                </div>
            </form>
        </div>
        <div class="flex flex-col gap-4 w-full lg:w-1/5">
            <div class="text-black w-full bg-base-100 rounded-lg shadow-lg p-4 h-fit">
                <h3 class="text-lg font-bold mb-4">Tips for a Good Question</h3>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Be specific and clear in your title</li>
                    <li>Provide context and background information</li>
                    <li>Include code examples if relevant</li>
                    <li>Explain what you've already tried</li>
                </ul>
            </div>
    
            @include('components.sidebar')
        </div>
    </main>
</div>

@push('scripts')
<script>
    $('.select2').select2({
        theme: 'bootstrap-5',
        tags: true,
        tokenSeparators: [',', ' '],
        placeholder: 'Add tags (comma separated)',
        allowClear: true,
        width: '100%'
    });
</script>
@endpush
@endsection
