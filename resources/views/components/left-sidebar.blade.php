<div class="w-fit bg-[#2A2649] rounded-lg p-4 h-fit">
    <nav class="flex flex-col space-y-4">
        
        <a href="{{ route('welcome') }}" 
           class="flex items-center gap-2 {{ request()->routeIs('welcome') ? 'text-[#FF6500]' : 'text-white' }} hover:text-[#FF6500] transition-colors p-2">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>

        <a href="{{ route('dashboard', ['filter' => 'newest']) }}" 
           class="flex items-center gap-2 {{ request()->input('filter') === 'newest' ? 'text-[#FF6500]' : 'text-white' }} hover:text-[#FF6500] transition-colors p-2">
            <i class="fas fa-question-circle"></i>
            <span>Questions</span>
        </a>

        <a href="{{ route('tags.index') }}" 
           class="flex items-center gap-2 {{ request()->routeIs('tags.index') ? 'text-[#FF6500]' : 'text-white' }} hover:text-[#FF6500] transition-colors p-2">
            <i class="fas fa-tags"></i>
            <span>Tags</span>
        </a>
    </nav>
</div>
