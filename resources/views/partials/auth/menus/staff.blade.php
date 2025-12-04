<a href="{{ route('staff.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('staff.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-rectangle-stack class="w-5 h-5" />
    Tahun Ajaran
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-clock class="w-5 h-5" />
    Jadwal Sekolah
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
    Jurusan
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-building-library class="w-5 h-5" />
    Kelas
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-users class="w-5 h-5" />
    Daftar Siswa
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-user-circle class="w-5 h-5" />
    Daftar Guru
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-building-office class="w-5 h-5" />
    Gedung dan Ruangan
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-document-chart-bar class="w-5 h-5" />
    Laporan Harian
</a>
