<!-- Sidebar Navigation -->
<nav class="mt-6 space-y-1">

    <div class="px-4 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
        {{ __('Menu') }}
    </div>

    {{-- Menu dinamis berdasarkan role --}}
    @switch(Auth::user()->role->lower_name)
        @case('admin')
            @include('partials.auth.menus.admin')
            @break

        @case('guru')
            @include('partials.auth.menus.teacher')
            @break

        @case('staff')
            @include('partials.auth.menus.staff')
            @break

        @case('siswa')
            @include('partials.auth.menus.student')
            @break

        @default
            <p class="text-sm text-gray-500 px-4 py-2">{{ __('No navigation available') }}</p>
    @endswitch
</nav>
