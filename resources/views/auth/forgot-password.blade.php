<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-950 px-4">
        <div class="flex flex-col items-center space-y-2 mb-6">
            <a href="/">
                <x-application-logo class="w-16 h-16 text-gray-700 dark:text-gray-300" />
            </a>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Forgot your password?</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center max-w-sm">
                No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>
        </div>

        <div class="w-full max-w-md bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="w-full">Email Password Reset Link</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
