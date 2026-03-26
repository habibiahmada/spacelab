@php
    $sectionTitleClass = 'px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500 mb-1';
    $linkClass = 'flex items-center gap-2.5 rounded-xl px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white';
    $activeClass = 'bg-slate-200 text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white';
@endphp

<div class="space-y-4">
    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Ringkasan</p>
        <a href="{{ route('staff.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.index') ? $activeClass : '' }}">
            <x-heroicon-o-home class="h-5 w-5" />
            Dashboard
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akademik</p>
        <a href="{{ route('staff.terms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.terms.*') ? $activeClass : '' }}">
            <x-heroicon-o-rectangle-stack class="h-5 w-5" />
            Tahun Ajaran
        </a>
        <a href="{{ route('staff.majors.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.majors.*') ? $activeClass : '' }}">
            <x-heroicon-o-squares-2x2 class="h-5 w-5" />
            Jurusan
        </a>
        <a href="{{ route('staff.classrooms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.classrooms.*') ? $activeClass : '' }}">
            <x-heroicon-o-building-library class="h-5 w-5" />
            Kelas
        </a>
        <a href="{{ route('staff.subjects.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.subjects.*') ? $activeClass : '' }}">
            <x-heroicon-o-book-open class="h-5 w-5" />
            Daftar Mata Pelajaran
        </a>
        <a href="{{ route('staff.schedules.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.schedules.*') ? $activeClass : '' }}">
            <x-heroicon-o-clock class="h-5 w-5" />
            Jadwal Sekolah
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Pengguna</p>
        <a href="{{ route('staff.students.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.students.*') ? $activeClass : '' }}">
            <x-heroicon-o-users class="h-5 w-5" />
            Daftar Siswa
        </a>
        <a href="{{ route('staff.teachers.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.teachers.*') ? $activeClass : '' }}">
            <x-heroicon-o-user-circle class="h-5 w-5" />
            Daftar Guru
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Fasilitas & Laporan</p>
        <a href="{{ route('staff.rooms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.rooms.index') ? $activeClass : '' }}">
            <x-heroicon-o-building-office class="h-5 w-5" />
            Gedung dan Ruangan
        </a>
        <a href="{{ route('staff.rooms.history') }}" class="{{ $linkClass }} {{ request()->routeIs('staff.rooms.history') ? $activeClass : '' }}">
            <x-heroicon-o-document-text class="h-5 w-5" />
            Riwayat Ruangan
        </a>
        <a href="#" class="{{ $linkClass }} {{ request()->routeIs('staff.reports.index') ? $activeClass : '' }}">
            <x-heroicon-o-document-chart-bar class="h-5 w-5" />
            Laporan Harian
        </a>
    </div>
</div>
