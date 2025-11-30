<a href="{{ route('guru.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('guru.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="{{ route('guru.schedules.index') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('guru.schedules.index') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Jadwal Mengajar
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('guru.reports') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-clipboard-document class="w-5 h-5" />
    Laporan Mengajar
</a>
