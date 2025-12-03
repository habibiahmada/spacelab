<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            Daftar Ruangan
        </h2>
    </x-slot>

    <div class="py-10">
        <div>
            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden
                        border border-gray-100 dark:border-gray-800 p-4 md:p-5
                        hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Hari Ini</p>
                            <h3 class="text-lg md:text-2xl font-semibold text-gray-900 dark:text-white capitalize">{{ now()->translatedformat('l') }}</h3>
                            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">{{ now()->translatedformat('H:i, d M Y') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center
                                    border border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-calendar class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" />
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden
                            border border-gray-100 dark:border-gray-800 p-4 md:p-5
                            hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Pelajaran Hari Ini</p>
                            <h3 class="text-2xl md:text-5xl font-extrabold text-gray-900 dark:text-white">{{ $todaySubjectsCount ?? 0 }}</h3>
                            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">mata pelajaran</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center
                                    border border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" />
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden
                        border border-gray-100 dark:border-gray-800 p-4 md:p-5
                        hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Ruangan</p>
                            <h3 class="text-2xl md:text-5xl font-extrabold text-gray-900 dark:text-white">{{ $todayRoomsCount ?? 0 }}</h3>
                            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">hari ini</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center
                                    border border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Statistik Ringkas --}}
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-6">
        <!-- Rooms in school List - 2/3 width -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
                    {{-- Konten Utama Halaman --}}
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lihat Ruangan Sekolah</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tampilkan daftar ruangan (dipakai / kosong) dan informasi penggunaannya hari ini.</p>
                        </div>
                        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama atau kode ruangan"
                                class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" />
                            <select name="filter" class="border border-gray-200 dark:border-gray-700 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                                <option value="">Semua</option>
                                <option value="occupied" {{ (request('filter') === 'occupied') ? 'selected' : '' }}>Dipakai</option>
                                <option value="empty" {{ (request('filter') === 'empty') ? 'selected' : '' }}>Kosong</option>
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white px-3 py-2 rounded-md text-sm">Cari</button>
                        </form>
                    </div>

                    {{-- Daftar Ruangan --}}
                    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kode / Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Gedung</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Kapasitas</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status Hari Ini</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-transparent divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($rooms as $room)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $room->code ?? '-' }} — {{ $room->name }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $room->notes ?? '' }}</div>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $room->building?->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-400">Lantai: {{ $room->floor ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center align-middle">
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $room->capacity ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        @if($room->todays_entries_count > 0)
                                            <div class="flex flex-col gap-2">
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    @foreach($room->timetableEntries as $entry)
                                                        @php
                                                            $period = $entry->period;
                                                            $time = '-';
                                                            if ($period && $period->start_time) {
                                                                $start = \Carbon\Carbon::createFromFormat('H:i:s', $period->start_time);
                                                                $time = $start->format('H:i');
                                                                if ($period->end_time) {
                                                                    $end = \Carbon\Carbon::createFromFormat('H:i:s', $period->end_time);
                                                                    $time .= ' - ' . $end->format('H:i');
                                                                }
                                                            }
                                                        @endphp
                                                        <div class="flex items-center justify-between">
                                                            @if($entry->isOngoing())
                                                            <div>
                                                                <div class="font-medium text-gray-900 dark:text-white">{{ $entry->subject?->name ?? '-' }}</div>
                                                                <div class="text-xs text-gray-500">{{ $entry->teacher?->user?->name ?? '-' }} • <span class="text-xs">{{ $time }}</span></div>
                                                            </div>
                                                                <div class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded font-semibold">Sedang berjalan</div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-2 py-1 rounded text-xs font-semibold">Kosong</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada ruangan ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Today's Rooms - 1/3 width -->
        <div class="lg:col-span-1">
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
                            {{-- Konten Utama Halaman --}}
                            <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Daftar Ruangan Hari Ini</h1>
                            {{-- Daftar ruangan yang dipakai hari ini (berdasarkan jadwal pelajaran) --}}
                            @if($todayRooms->isEmpty())
                                <p class="text-gray-700 dark:text-gray-300">Tidak ada ruangan yang dipakai hari ini.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach($todayRooms as $room)
                                        <div class="p-3 border border-gray-100 dark:border-gray-800 rounded-lg bg-white dark:bg-gray-900">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $room->code ?? 'N/A' }} — {{ $room->name ?? 'Tanpa Ruangan' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $room->building?->name ?? '-' }}</div>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $room->todays_entries_count ?? $room->timetableEntries->count() }} jadwal</div>
                                            </div>
                                            <div class="mt-3 space-y-2">
                                                @foreach($room->timetableEntries as $entry)
                                                    @php
                                                        $period = $entry->period;
                                                        $time = '-';
                                                        if ($period && $period->start_time) {
                                                            $start = \Carbon\Carbon::createFromFormat('H:i:s', $period->start_time);
                                                            $time = $start->format('H:i');
                                                            if ($period->end_time) {
                                                                $end = \Carbon\Carbon::createFromFormat('H:i:s', $period->end_time);
                                                                $time .= ' - ' . $end->format('H:i');
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $entry->subject?->name ?? '-' }}</div>
                                                            <div class="text-xs text-gray-500">{{ $entry->teacher?->user?->name ?? '-' }} • {{ $time }}</div>
                                                        </div>
                                                        @if($entry->isOngoing())
                                                            <div class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded font-semibold">Sedang berjalan</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    {{ $todayRooms->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
