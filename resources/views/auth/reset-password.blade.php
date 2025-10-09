<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-950 px-4">
        <div class="flex flex-col items-center space-y-2 mb-6">
            <a href="/">
                <x-application-logo class="w-16 h-16 text-gray-700 dark:text-gray-300" />
            </a>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Reset Password</h1>
        </div>

        <div class="w-full max-w-md bg-white dark:bg-gray-900 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-800">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="space-y-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-400 focus:ring-opacity-30 transition" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button class="w-full">Reset Password</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>