<x-guest-layout :title="$title" :description="$description">
    <div class="min-h-screen flex">
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-950">
            <div class="w-full max-w-md">
                <!-- Logo & Header -->
                <div class="text-center mb-8 ">
                    <a href="/" class="inline-block mb-6 shadow-lg text-2xl">
                        <x-application-logo class="w-36 h-36" />
                    </a>
                    <h1 class="text-3xl font-bold mb-2">
                        Selamat Datang Kembali
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        Masuk untuk melanjutkan ke dashboard
                    </p>
                </div>

                <!-- Login Form -->
                <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-8 border border-slate-200 dark:border-slate-800">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium mb-2">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-envelope class="h-5 w-5 text-blue-300" />
                                </div>
                                <input id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-950  placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 dark:focus:ring-blue-700 focus:border-transparent transition"
                                    placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-sm font-medium mb-2">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-lock-closed class="h-5 w-5 text-blue-300" />
                                </div>
                                <input id="password" 
                                    :type="show ? 'text' : 'password'" 
                                    name="password" 
                                    required
                                    class="block w-full pl-10 pr-10 py-2.5 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-950  placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 dark:focus:ring-blue-700 focus:border-transparent transition"
                                    placeholder="••••••••">
                                <button type="button" 
                                    @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-300 hover:text-slate-600 dark:hover:text-slate-300">
                                    <x-heroicon-o-eye class="h-5 w-5" x-show="!show" />
                                    <x-heroicon-o-eye-slash class="h-5 w-5" x-show="show" x-cloak />
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <input id="remember_me" 
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 rounded border-slate-300 dark:border-blue-700 dark:text-blue-700 focus:ring-blue-900 dark:focus:ring-blue-700">
                                <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-medium  hover:text-slate-700 dark:hover:text-slate-300 transition">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-500 dark:bg-slate-700 text-white rounded-lg hover:bg-blue-600 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-900 dark:focus:ring-blue-700 focus:ring-offset-2 transition font-medium">
                            <span>Masuk</span>
                        </button>
                    </form>
                </div>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="/" class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition">
                        <x-heroicon-o-arrow-left class="w-4 h-4" />
                        <span>Kembali ke beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

