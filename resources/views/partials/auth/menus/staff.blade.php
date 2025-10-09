<a href="{{ route('staff.dashboard') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('staff.dashboard') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-calendar-days class="w-5 h-5" />
    Jadwal Sekolah
</a>

<a href="#"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-chart-pie class="w-5 h-5" />
    Laporan Harian
</a>
