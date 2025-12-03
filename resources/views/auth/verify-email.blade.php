<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-950 px-4 space-y-6">
        <div class="text-center max-w-md space-y-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                If you didn't receive the email, we will gladly send you another.
            </p>
            @if (session('status') == 'verification-link-sent')
                <p class="text-sm text-green-600 dark:text-green-400 font-medium">
                    A new verification link has been sent to the email address you provided during registration.
                </p>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between w-full max-w-md space-y-4 sm:space-y-0 sm:space-x-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <x-primary-button class="w-full">Resend Verification Email</x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <x-secondary-button type="submit" class="w-full">Log Out</x-secondary-button>
            </form>
        </div>
    </div>
</x-guest-layout>
