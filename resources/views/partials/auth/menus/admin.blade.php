<a href="{{ route('admin.dashboard') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md 
          hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.dashboard') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-home class="w-5 h-5" />
    Dashboard
</a>

<a href="{{ route('admin.teachers.index') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.teachers.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-academic-cap class="w-5 h-5" />
    Guru
</a>

<a href="{{ route('admin.students.index') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.students.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-user-group class="w-5 h-5" />
    Siswa
</a>

<a href="{{ route('admin.classes.index')  }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.classes.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-rectangle-stack class="w-5 h-5" />
    Kelas
</a>
<a href="{{  route('admin.majors.index') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.majors.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
          <x-heroicon-o-academic-cap class="w-5 h-5" />
    Jurusan
</a>

<a href="{{ route('admin.rooms.index') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.rooms.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-building-office class="w-5 h-5" />
    Ruangan
</a>

<a href="{{ route('admin.schedules.index') }}"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.schedules.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-calendar-days class="w-5 h-5" />
    Jadwal
</a>

<a href="#"
   class="flex items-center gap-3 px-5 py-2 text-sm rounded-md hover:bg-slate-200 dark:hover:bg-slate-800
          {{ request()->routeIs('admin.reports.*') ? 'bg-slate-200 dark:bg-slate-800 font-semibold' : '' }}">
    <x-heroicon-o-chart-bar class="w-5 h-5" />
    Laporan
</a>
