    <nav class="fixed inset-x-0 top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm border-b border-gray-100 dark:border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo />
                    <span class="text-lg font-semibold">SpaceLab</span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6 text-sm">
                <a href="#features" class="hover:text-accent transition">Features</a>
                <a href="#benefits" class="hover:text-accent transition">Benefits</a>
                <a href="#pricing" class="hover:text-accent transition">Pricing</a>
            </div>

            <div class="flex items-center space-x-3 text-sm">
                @auth
                    <a href="{{ route(Auth::user()->role->lower_name . '.dashboard') }}" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border text-[#1b1b18] dark:text-[#EDEDEC]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-accent transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:text-accent transition px-5 py-1.5 rounded-sm text-sm leading-normal border text-[#1b1b18] dark:text-[#EDEDEC]">Get Started</a>
                    @endif
                @endauth

                <!-- Mobile menu -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition" aria-label="Open menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>