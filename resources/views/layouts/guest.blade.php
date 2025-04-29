@extends('layouts.main')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#1B1833]">
    <a href="/" class="text-3xl text-white">
        <span class="text-[#FF6500]">Re</span>:<span class="text-[#48CFCB]">CODE</span>
    </a>    

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

        {{ $slot }}
    </div>
</div>
@endsection
