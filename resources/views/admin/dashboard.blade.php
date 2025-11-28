<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            Hai {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Cards -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach([
                    ['Guru', $teachers, 'neskar.blue-500', 'heroicon-o-academic-cap'],
                    ['Siswa', $students, 'neskar.green-500', 'heroicon-o-user-group'],
                    ['Kelas', $classes, 'neskar.yellow-500', 'heroicon-o-queue-list'],
                    ['Ruangan', $rooms, 'neskar.red-500', 'heroicon-o-building-library'],
                    ['Jadwal Hari Ini', $schedules_today, 'neskar.blue-600', 'heroicon-o-calendar-days']
                ] as [$label, $count, $color, $icon])
                <div class="bg-white dark:bg-slate-800 shadow-sm rounded-lg p-5 flex items-center gap-4">
                    <div class="p-3 rounded-md bg-opacity-10" style="background-color: theme('colors.{{ $color }}')">
                        <x-dynamic-component :component="$icon" class="w-6 h-6 text-{{ $color }}" />
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-neskar.neutral-800 dark:text-white">{{ $count }}</div>
                        <div class="text-sm text-neskar.neutral-500 dark:text-neskar.neutral-400">{{ $label }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-neskar.blue-700 dark:text-white">Jadwal Hari Ini</h3>
                    <a href="{{ route('admin.schedules.index') }}" class="text-sm text-neskar.blue-500 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-neskar.blue-50 dark:bg-slate-700 text-neskar.neutral-600 dark:text-neskar.neutral-300">
                            <tr>
                                <th class="px-4 py-2 text-left">Ruangan</th>
                                <th class="px-4 py-2 text-left">Kelas</th>
                                <th class="px-4 py-2 text-left">Guru</th>
                                <th class="px-4 py-2 text-left">Mapel</th>
                                <th class="px-4 py-2 text-left">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-slate-700">
                            @forelse($todaySchedules as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->room->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->class->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->teacher->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->subject->name ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->start_at->format('H:i') }} - {{ $item->end_at->format('H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-neskar.neutral-500">Tidak ada jadwal hari ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-neskar.blue-700 dark:text-white">Aktivitas Terbaru</h3>
                    <a href="#" class="text-sm text-neskar.blue-500 hover:underline">Lihat Semua</a>
                </div>
                <ul class="divide-y dark:divide-slate-700">
                    @forelse($recentLogs as $log)
                    <li class="p-4 text-sm text-neskar.neutral-700 dark:text-neskar.neutral-300">
                        <span class="font-medium text-neskar.blue-600">{{ $log->user->name ?? 'Sistem' }}</span>
                        melakukan <span class="font-semibold">{{ $log->action }}</span> pada
                        <span class="italic">{{ $log->entity }}</span>
                        <span class="text-neskar.neutral-400 text-xs block mt-1">{{ $log->created_at->diffForHumans() }}</span>
                    </li>
                    @empty
                    <li class="p-4 text-center text-neskar.neutral-500">Belum ada aktivitas terbaru</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
