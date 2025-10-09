<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-950 px-4">
        <!-- Logo -->
        <div class="flex flex-col items-center space-y-2 mb-8">
            <a href="/" class="flex items-center justify-center">
                <x-application-logo class="w-16 h-16 text-gray-700 dark:text-gray-300" />
            </a>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">
                Welcome Back
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Sign in to continue to your account
            </p>
        </div>

        <!-- Form Card -->
        <div class="w-full max-w-md bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center space-x-2">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500" name="remember">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center rounded-xl bg-indigo-600 text-white font-medium py-2.5 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-400 focus:ring-opacity-30 transition">
                        Log In
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center mt-8">
                <span class="h-px w-1/4 bg-gray-200 dark:bg-gray-700"></span>
                <span class="px-3 text-xs text-gray-400 uppercase">or</span>
                <span class="h-px w-1/4 bg-gray-200 dark:bg-gray-700"></span>
            </div>

            <!-- Register Link -->
            <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
