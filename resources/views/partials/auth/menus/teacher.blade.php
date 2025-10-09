<a href="{{ route('guru.dashboard') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('teacher.dashboard') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('teacher.schedules') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Jadwal Mengajar
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('teacher.reports') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-clipboard-document class="w-5 h-5" />
    Laporan Mengajar
</a>
