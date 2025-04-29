@extends('layouts.main')

@section('content')
<div class="bg-[#1B1833] text-white font-bold flex min-h-screen flex-col">
    @include('layouts.navigation')
    
    @auth
        <div class=" bg-gradient-to-r from-[#1B1833] to-[#2A2649]">
            <div class="px-10 py-3">
                <h2 class="text-2xl mb-2">
                    Welcome back, <span class="text-[#7AE2CF]">{{ auth()->user()->username }}</span>! 
                    <span class="text-sm font-normal ml-2">{{ now()->format('l, F j') }}</span>
                </h2>
                <p class="text-gray-400">What interesting topic would you like to explore today?</p>
            </div>
        </div>
        @else
            <div class=" bg-gradient-to-r from-[#1B1833] to-[#2A2649]">
                <div class="px-10 py-3">
                    <h2 class="text-2xl mb-2">
                        Hello! Welcome to
                        <a href="/"
                        class="text-3xl">
                        <span class="text-[#FF6500]">Re</span>:<span class="text-[#48CFCB]">CODE</span>
                        </a>
                    </h2>
                    <p class="text-gray-400">
                        <a href="{{ route('login') }}" class="text-[#FF6500]">Log in</a>
                        or                     
                        <a href="{{ route('register') }}" class="text-[#48CFCB]">Sign up</a>
                        now to join the diverse programming community.
                    </p>
                </div>
            </div>
    @endauth
    
    @include('homePartial', [
        'questions' => $questions, 
        'popularQuestions' => $popularQuestions ?? collect()
    ])
    
</div>
@endsection
