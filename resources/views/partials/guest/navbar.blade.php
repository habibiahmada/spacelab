<nav class="fixed inset-x-0 top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm border-b border-gray-100 dark:border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo />
                    <span class="text-lg font-semibold">SpaceLab</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6 text-sm">
                <a href="#features" class="hover:text-accent transition">Fitur</a>
                <a href="#how-it-works" class="hover:text-accent transition">Cara Kerja</a>
                <a href="#benefits" class="hover:text-accent transition">Keunggulan</a>
                <a href="#faqs" class="hover:text-accent transition">FAQ</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3 text-sm">

                <!-- Auth Links -->
                @auth
                    <a href="{{ route(Auth::user()->role->lower_name . '.dashboard') }}" 
                       class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal border text-[#1b1b18] dark:text-[#EDEDEC]">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-accent transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="hover:text-accent transition px-5 py-1.5 rounded-sm text-sm leading-normal border text-[#1b1b18] dark:text-[#EDEDEC]">
                            Get Started
                        </a>
                    @endif
                @endauth

                <!-- Dark Mode Toggle -->
                <button 
                    x-data="{ 
                        darkMode: localStorage.getItem('dark') 
                            ? localStorage.getItem('dark') === 'true' 
                            : window.matchMedia('(prefers-color-scheme: dark)').matches 
                    }"
                    x-init="$watch('darkMode', value => {
                        document.documentElement.classList.toggle('dark', value);
                        localStorage.setItem('dark', value);
                    }); 
                    // Set class sesuai initial value
                    document.documentElement.classList.toggle('dark', darkMode);"
                    @click="darkMode = !darkMode"
                    class="p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                    aria-label="Toggle Dark Mode"
                >
                    <template x-if="!darkMode">
                        <x-heroicon-o-moon class="w-6 h-6 text-gray-800 dark:text-gray-200" />
                    </template>
                    <template x-if="darkMode">
                        <x-heroicon-o-sun class="w-6 h-6 text-gray-800 dark:text-gray-200" />
                    </template>
                </button>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800 transition" aria-label="Open menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

            </div>
        </div>
    </div>
</nav>