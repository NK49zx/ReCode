<nav class="mb-8 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-around">
            <!-- Activity Section -->
            <a href="{{ route('profile.edit') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.edit') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Profile Settings
            </a>

            <a href="{{ route('profile.questions') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.questions') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Your Questions
            </a>

            <a href="{{ route('profile.answers') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.answers') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Your Answers
            </a>

            <!-- Collections Section -->
            <a href="{{ route('profile.bookmarks') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.bookmarks') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Bookmarks
            </a>
            
            <!-- Engagement Section -->
            <a href="{{ route('profile.upvoted') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.upvoted') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Upvoted
            </a>

            <!-- Stats Section -->
            <a href="{{ route('profile.stats') }}" 
               class="text-white border-b-2 {{ request()->routeIs('profile.stats') ? 'border-[#FF6500]' : 'border-transparent' }} hover:border-[#FF6500] px-1 py-4 text-sm font-medium">
                Activity Stats
            </a>
        </div>
    </div>
</nav>
