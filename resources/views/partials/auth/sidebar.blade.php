<!-- Sidebar Navigation -->
<nav class="px-3 pb-4">
    <div class="space-y-3 border-t border-slate-200/80 bg-white/80 p-2.5 shadow-sm dark:border-slate-700 dark:bg-slate-900/60">
        {{-- Menu dinamis berdasarkan role --}}
        @switch(Auth::user()->role->lower_name)
            @case('admin')
                @include('partials.auth.menus.admin')
                @break

            @case('guru')
                @php
                    $isUserIsGuardian = false;
                    $isHeadOfMajor = false;
                    $isProgramCoordinator = false;

                    $user = Auth::user();
                    if ($user && $user->teacher) {
                        $isUserIsGuardian = $user->teacher->guardianClassHistories()->where(function ($q) {
                            $q->whereNull('ended_at')->orWhere('ended_at', '>=', \Carbon\Carbon::now());
                        })->exists();

                        $teacher = $user->teacher;
                        $isHeadOfMajor = $teacher ? $teacher->roleAssignments()->exists() : false;
                        $isProgramCoordinator = $teacher ? $teacher->asCoordinatorAssignments()->exists() : false;
                    }
                @endphp

                @include('partials.auth.menus.teacher', [
                    'isUserIsGuardian' => $isUserIsGuardian,
                    'isHeadOfMajor' => $isHeadOfMajor,
                    'isProgramCoordinator' => $isProgramCoordinator,
                ])
                @break

            @case('staff')
                @include('partials.auth.menus.staff')
                @break

            @case('siswa')
                @include('partials.auth.menus.student')
                @break

            @default
                <p class="px-3 py-2 text-sm text-slate-500 dark:text-slate-400">{{ __('No navigation available') }}</p>
        @endswitch
    </div>
</nav>
