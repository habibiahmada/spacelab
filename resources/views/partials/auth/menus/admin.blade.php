@php
    $sectionTitleClass = 'px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400 dark:text-slate-500 mb-1';
    $linkClass = 'flex items-center gap-2.5 rounded-xl px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white';
    $activeClass = 'bg-slate-200 text-slate-900 shadow-sm dark:bg-slate-800 dark:text-white';
@endphp

<div class="space-y-4">
    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Ringkasan</p>
        <a href="{{ route('admin.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.index') ? $activeClass : '' }}">
            <x-heroicon-o-home class="h-5 w-5" />
            Dashboard
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Akademik</p>
        <a href="{{ route('admin.attendance.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.attendance.*') ? $activeClass : '' }}">
            <x-heroicon-o-clock class="h-5 w-5" />
            Kelola Absensi
        </a>
        <a href="{{ route('admin.terms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.terms.*') ? $activeClass : '' }}">
            <x-heroicon-o-rectangle-stack class="h-5 w-5" />
            Tahun Ajaran
        </a>
        <a href="{{ route('admin.majors.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.majors.*') ? $activeClass : '' }}">
            <x-heroicon-o-squares-2x2 class="h-5 w-5" />
            Jurusan
        </a>
        <a href="{{ route('admin.classrooms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.classrooms.*') ? $activeClass : '' }}">
            <x-heroicon-o-building-library class="h-5 w-5" />
            Kelas
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.subjects.*') ? $activeClass : '' }}">
            <x-heroicon-o-book-open class="h-5 w-5" />
            Daftar Mata Pelajaran
        </a>
        <a href="{{ route('admin.schedules.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.schedules.*') ? $activeClass : '' }}">
            <x-heroicon-o-clock class="h-5 w-5" />
            Kelola Jadwal
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Pengguna</p>
        <a href="{{ route('admin.students.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.students.*') ? $activeClass : '' }}">
            <x-heroicon-o-users class="h-5 w-5" />
            Daftar Siswa
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.teachers.*') ? $activeClass : '' }}">
            <x-heroicon-o-user-circle class="h-5 w-5" />
            Daftar Guru
        </a>
        <a href="{{ route('admin.staff.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.staff.*') ? $activeClass : '' }}">
            <x-heroicon-o-user-group class="h-5 w-5" />
            Daftar Staff
        </a>
    </div>

    <div class="space-y-0.5">
        <p class="{{ $sectionTitleClass }}">Fasilitas & Laporan</p>
        <a href="{{ route('admin.rooms.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.rooms.index') ? $activeClass : '' }}">
            <x-heroicon-o-building-office class="h-5 w-5" />
            Gedung dan Ruangan
        </a>
        <a href="{{ route('admin.rooms.history') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.rooms.history') ? $activeClass : '' }}">
            <x-heroicon-o-document-text class="h-5 w-5" />
            Penggunaan Ruangan
        </a>
        <a href="{{ route('admin.cctv.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.cctv.*') ? $activeClass : '' }}">
            <x-heroicon-o-video-camera class="h-5 w-5" />
            <span>Pantau Ruangan</span>
            <span class="ml-auto flex items-center">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
            </span>
        </a>
        <a href="{{ route('admin.reports.index') }}" class="{{ $linkClass }} {{ request()->routeIs('admin.reports.*') ? $activeClass : '' }}">
            <x-heroicon-o-document-chart-bar class="h-5 w-5" />
            Laporan Harian
        </a>
    </div>
</div>
