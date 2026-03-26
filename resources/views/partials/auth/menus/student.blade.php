@php
    $sectionTitleClass = 'px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500 mb-1';
    $linkClass = 'flex items-center gap-2.5 rounded-xl px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white';
    $activeClass = 'bg-slate-200 text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white';
@endphp

<div class="space-y-4">
    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akademik</p>
        <a href="{{ route('siswa.index') }}" class="{{ $linkClass }} {{ request()->routeIs('siswa.index') ? $activeClass : '' }}">
            <x-heroicon-o-home class="h-5 w-5" />
            Dashboard
        </a>
        <a href="{{ route('siswa.schedules.index') }}" class="{{ $linkClass }} {{ request()->routeIs('siswa.schedules.*') ? $activeClass : '' }}">
            <x-heroicon-o-calendar class="h-5 w-5" />
            Jadwal Pelajaran
        </a>
        <a href="{{ route('siswa.classroom.index') }}" class="{{ $linkClass }} {{ request()->routeIs('siswa.classroom.*') ? $activeClass : '' }}">
            <x-heroicon-c-queue-list class="h-5 w-5" />
            Kelas Saya
        </a>
        <a href="{{ route('siswa.rooms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('siswa.rooms.*') ? $activeClass : '' }}">
            <x-heroicon-s-rocket-launch class="h-5 w-5" />
            Daftar Ruangan
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akun</p>
        <a href="{{ route('siswa.profile.index') }}" class="{{ $linkClass }} {{ request()->routeIs('siswa.profile.*') ? $activeClass : '' }}">
            <x-heroicon-o-user class="h-5 w-5" />
            Profil Saya
        </a>
    </div>
</div>
