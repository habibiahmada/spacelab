<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik Ringkas --}}
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                    <div>
                        <p class="text-sm opacity-80">Pelajaran Hari Ini</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $countToday }}</h3>
                    </div>
                    <div class="flex justify-end">
                        <x-heroicon-o-book-open class="w-10 h-10 opacity-70" />
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-700 text-white rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                    <div>
                        <p class="text-sm opacity-80">Hari Ini</p>
                        <h3 class="text-2xl font-bold mt-2 capitalize">{{ $today }}</h3>
                    </div>
                    <div class="flex justify-end">
                        <x-heroicon-o-calendar class="w-10 h-10 opacity-70" />
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                    <div>
                        <p class="text-sm opacity-80">Nama Siswa</p>
                        <h3 class="text-xl font-semibold mt-2">{{ $student->user->name }}</h3>
                    </div>
                    <div class="flex justify-end">
                        <x-heroicon-o-user class="w-10 h-10 opacity-70" />
                    </div>
                </div>
            </div>

            {{-- Jadwal Hari Ini --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-800 dark:text-gray-100">
                    <x-heroicon-o-clock class="w-5 h-5 text-blue-600 dark:text-yellow-400" />
                    Jadwal Hari Ini
                </h3>

                @if ($todaySchedules->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada pelajaran hari ini 🎉</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
                            <thead>
                                <tr class="border-b border-gray-300 dark:border-gray-700 text-left">
                                    <th class="py-3">Jam</th>
                                    <th class="py-3">Mata Pelajaran</th>
                                    <th class="py-3">Guru</th>
                                    <th class="py-3">Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todaySchedules as $schedule)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-slate-50 dark:hover:bg-slate-900 transition">
                                        <td class="py-3">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                        <td class="py-3 font-medium">{{ $schedule->subject->name ?? '-' }}</td>
                                        <td class="py-3 flex items-center gap-3">
                                            <img src="{{ $schedule->teacher->user->profile_photo_url ?? asset('images/default-teacher.png') }}"
                                                 alt="Guru"
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-blue-300 dark:border-yellow-400">
                                            <span>{{ $schedule->teacher->user->name ?? '-' }}</span>
                                        </td>
                                        <td class="py-3">{{ $schedule->room->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>