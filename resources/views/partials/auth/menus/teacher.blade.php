@php
    $sectionTitleClass = 'px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500 mb-1';
    $linkClass = 'flex items-center gap-2.5 rounded-xl px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white';
    $activeClass = 'bg-slate-200 text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white';
@endphp

<div class="space-y-4">
    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akademik</p>
        <a href="{{ route('guru.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.index') ? $activeClass : '' }}">
            <x-heroicon-o-home class="h-5 w-5" />
            Dashboard
        </a>
        <a href="{{ route('guru.schedules.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.schedules.*') ? $activeClass : '' }}">
            <x-heroicon-o-calendar class="h-5 w-5" />
            Jadwal Mengajar
        </a>
    </div>

    @if($isUserIsGuardian || $isHeadOfMajor || $isProgramCoordinator)
        <div class="space-y-0.5">
            <p class="{{ $sectionTitleClass }}">Tugas Tambahan</p>
            @if($isUserIsGuardian)
                <a href="{{ route('guru.classroom.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.classrooms.*') || request()->routeIs('guru.classroom.*') ? $activeClass : '' }}">
                    <x-heroicon-o-users class="h-5 w-5" />
                    Kelas Saya
                </a>
            @endif

            @if($isHeadOfMajor)
                <a href="{{ route('guru.major.majorhead.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.major.majorhead.*') ? $activeClass : '' }}">
                    <x-heroicon-o-academic-cap class="h-5 w-5" />
                    Jurusan (Kepala Program)
                </a>
            @endif

            @if($isProgramCoordinator)
                <a href="{{ route('guru.major.majorprogram.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.major.majorprogram.*') ? $activeClass : '' }}">
                    <x-heroicon-o-rectangle-stack class="h-5 w-5" />
                    Jurusan (Koordinator)
                </a>
            @endif
        </div>
    @endif

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akun</p>
        <a href="{{ route('guru.profile.index') }}" class="{{ $linkClass }} {{ request()->routeIs('guru.profile.*') ? $activeClass : '' }}">
            <x-heroicon-o-user class="h-5 w-5" />
            Profil
        </a>
    </div>
</div>
