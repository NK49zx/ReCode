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
                    <h1 class="text-3xl">Tags</h1>
                    <div class="flex gap-4">
                        <form method="GET" class="flex gap-2">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search tags..." 
                                   value="{{ request('search') }}"
                                   class="input input-bordered bg-[#2A2649] text-white">
                            
                            <select name="sort" class="select select-bordered bg-[#2A2649] text-white">
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                            </select>
                            
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($tags as $tag)
                        <a href="{{ route('tags.show', $tag) }}" class="bg-[#2A2649] p-4 rounded-lg hover:bg-[#353156] transition-colors">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-[#FF6500]">{{ $tag->name }}</h3>
                                <span class="badge badge-primary">{{ $tag->questions_count }}</span>
                            </div>
                            <p class="text-sm text-gray-400">
                                {{ $tag->questions_count }} {{ Str::plural('question', $tag->questions_count) }}
                            </p>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $tags->withQueryString()->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
