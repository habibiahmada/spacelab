<a href="{{ route('staff.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('staff.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="{{ route('staff.terms.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.terms.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-rectangle-stack class="w-5 h-5" />
    Tahun Ajaran
</a>

<a href="{{ route('staff.majors.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.majors.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
    Jurusan
</a>

<a href="{{ route('staff.classrooms.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.classrooms.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-building-library class="w-5 h-5" />
    Kelas
</a>

<a href="{{ route('staff.students.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.students.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-users class="w-5 h-5" />
    Daftar Siswa
</a>

<a href="{{ route('staff.teachers.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.teachers.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-user-circle class="w-5 h-5" />
    Daftar Guru
</a>

<a href="{{ route('staff.subjects.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.subjects.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-book-open class="w-5 h-5" />
    Daftar Mata Pelajaran
</a>

<a href="{{ route('staff.rooms.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.rooms.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-building-office class="w-5 h-5" />
    Gedung dan Ruangan
</a>

<a href="{{ route('staff.rooms.history') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.rooms.history') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-document-text class="w-5 h-5" />
    Riwayat Ruangan
</a>

<a href="{{ route('staff.schedules.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.schedules.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-clock class="w-5 h-5" />
    Jadwal Sekolah
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
   {{ request()->routeIs('staff.reports.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-document-chart-bar class="w-5 h-5" />
    Laporan Harian
</a>
