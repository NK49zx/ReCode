@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-[#18162c] pb-10">
    @include('layouts.navigation')
    <div class="max-w-xl mx-auto mt-10 bg-[#23204a] p-6 rounded shadow text-white">
        <h1 class="text-2xl font-bold mb-4 text-[#FF6500]">Report {{ ucfirst($type) }}</h1>
        <form action="{{ route('report.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            @if($question)
                <input type="hidden" name="question_id" value="{{ $question->id }}">
            @endif
            @if($answer)
                <input type="hidden" name="answer_id" value="{{ $answer->id }}">
            @endif
            @if($user)
                <input type="hidden" name="user_id" value="{{ $user->id }}">
            @endif
            <div class="mb-4">
                <label class="block font-semibold mb-1">Reason for Report</label>
                <textarea name="reason" rows="4" class="w-full border rounded p-2 text-black" required></textarea>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-[#FF6500] text-white px-4 py-2 rounded">Submit Report</button>
                <a href="{{ $question ? route('question.show', $question->id) : url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
