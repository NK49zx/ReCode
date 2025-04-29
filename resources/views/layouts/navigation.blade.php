<header class="w-full text-lg p-10 mb-6 bg-[#1B1833]">
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            <div class="flex self-start gap-4 justify-start mr-auto">
                <a href="/"
                class="text-3xl">
                <span class="text-[#FF6500]">Re</span>:<span class="text-[#48CFCB]">CODE</span>
                </a>
                
                <a 
                href="/"
                class="inline-block px-5 py-1.5 text-white border border-transparent hover:border-white dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">About</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="inline-block px-5 py-1.5 text-white border border-transparent hover:border-white dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">Admin Panel</a>
                    @endif
                @endauth
            </div>

            <div class="relative w-2/4 text-black">
                <input type="text" 
                       id="search-input"
                       placeholder="Search questions..." 
                       class="input input-bordered w-full" 
                       autocomplete="off" />
                <div id="search-dropdown" class="absolute w-full mt-1 bg-white rounded-md shadow-lg z-50" style="display:none;">
                    <div id="search-results" class="max-h-96 overflow-y-auto"></div>
                </div>
            </div>

            @auth
                <a
                href="{{ route('profile.edit') }}"
                class="inline-block px-5 py-1.5 text-white border border-transparent hover:border-white dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    {{ Auth::user()->username }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-block px-5 py-1.5 text-white border-white border text-[#1b1b18] rounded-sm text-sm leading-normal">
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 text-white border border-transparent hover:border-white dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 text-white border-white border text-[#1b1b18] rounded-sm text-sm leading-normal">    
                        Register
                    </a>
                @endif
            @endauth
            
        </nav>
    @endif
</header>

@push('scripts')
    <script src="{{ asset('js/newsearch.js') }}"></script>
@endpush