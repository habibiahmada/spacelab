<a href="{{ route('student.dashboard') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('student.dashboard') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="{{ route('student.schedule') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-calendar class="w-5 h-5" />
    Jadwal Pelajaran
</a>

<a href="{{ route('student.profile') }}"
   class="flex items-center gap-3 px-4 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800">
    <x-heroicon-o-user class="w-5 h-5" />
    Profil Saya
</a>
