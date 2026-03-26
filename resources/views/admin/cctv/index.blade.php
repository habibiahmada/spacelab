<x-app-layout title="Pantau Ruangan" description="Pantau ruangan aktif dan status kamera CCTV">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Pantau Ruangan
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-900/50 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex  justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Ringkasan Pantauan</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Cari ruangan lebih cepat dan lihat status kelas yang sedang berjalan.</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.cctv.playback.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <x-heroicon-o-play class="w-4 h-4 mr-2" />
                            Playback
                        </a>
                        <a href="{{ route('admin.cctv.health.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <x-heroicon-o-heart class="w-4 h-4 mr-2" />
                            Kesehatan CCTV
                        </a>
                        <a href="{{ route('admin.cctv.settings.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <x-heroicon-o-cog-6-tooth class="w-4 h-4 mr-2" />
                            Pengaturan
                        </a>
                    </div>
                </div>

                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-3">
                        <div class="rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Total Ruangan</p>
                            <p class="mt-2 text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $totalFiltered }}</p>
                        </div>
                        <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-700 dark:text-green-300">Ruangan Aktif</p>
                            <p class="mt-2 text-2xl font-bold text-green-900 dark:text-green-100">{{ $activeRoomCount }}</p>
                        </div>
                        <div class="rounded-xl border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">Kamera Terkonfigurasi</p>
                            <p class="mt-2 text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $configuredCount }}</p>
                        </div>
                        <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-300">Tanpa Kamera</p>
                            <p class="mt-2 text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $noCameraCount }}</p>
                        </div>
                        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-300">Kamera Online</p>
                            <p class="mt-2 text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ $onlineCount }}</p>
                        </div>
                        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-700 dark:text-red-300">Kamera Offline</p>
                            <p class="mt-2 text-2xl font-bold text-red-900 dark:text-red-100">{{ $offlineCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <form method="GET" action="{{ route('admin.cctv.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-3">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari ruangan, gedung, guru, mapel, atau jurusan..."
                            class="xl:col-span-2 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">

                        <select name="camera_type"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($cameraType === 'all')>Semua Tipe Kamera</option>
                            <option value="none" @selected($cameraType === 'none')>Tidak Ada</option>
                            <option value="webcam" @selected($cameraType === 'webcam')>Webcam Laptop</option>
                            <option value="ip_camera" @selected($cameraType === 'ip_camera')>IP Camera</option>
                        </select>

                        <select name="room_status"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($roomStatus === 'all')>Semua Status Ruangan</option>
                            <option value="active" @selected($roomStatus === 'active')>Sedang Dipakai</option>
                            <option value="empty" @selected($roomStatus === 'empty')>Tidak Dipakai</option>
                        </select>

                        <select name="building_id"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($buildingId === 'all')>Semua Gedung</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}" @selected($buildingId === (string) $building->id)>
                                    {{ $building->code }} - {{ $building->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="per_page"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="10" @selected($perPage === 10)>10 / halaman</option>
                            <option value="15" @selected($perPage === 15)>15 / halaman</option>
                            <option value="25" @selected($perPage === 25)>25 / halaman</option>
                            <option value="50" @selected($perPage === 50)>50 / halaman</option>
                        </select>

                        <div class="xl:col-span-6 flex items-center gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Terapkan Filter
                            </button>

                            @if (
                                $search !== '' ||
                                    $cameraType !== 'all' ||
                                    $roomStatus !== 'all' ||
                                    $buildingId !== 'all' ||
                                    $perPage !== 10)
                                <a href="{{ route('admin.cctv.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-auto divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="w-12 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">No</th>
                                <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Ruangan</th>
                                <th class="w-32 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Gedung</th>
                                <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kelas Aktif</th>
                                <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Guru / Mapel</th>
                                <th class="w-24 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Jam</th>
                                <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kamera</th>
                                <th class="w-48 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Preview</th>
                                <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                                <th class="w-44 px-3 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900/50">
                            @forelse ($rooms as $room)
                                @php
                                    $entry = $room->activeEntry;
                                    $classroom = $entry ? optional($entry->template)->class : null;
                                    $teacher = $entry ? optional($entry->teacherSubject)->teacher : null;
                                    $subject = $entry ? optional($entry->teacherSubject)->subject : null;
                                    $period = $entry ? $entry->period : null;

                                    $className = $classroom?->name ?? '-';
                                    $majorName = $classroom && $classroom->major ? ($classroom->major->code ?? $classroom->major->name) : null;
                                    $teacherName = $teacher?->name ?? '-';
                                    $subjectName = $subject?->name ?? '-';
                                    $timeRange = $period ? substr($period->start_time, 0, 5) . ' - ' . substr($period->end_time, 0, 5) : '-';
                                    $activeHistory = $room->roomHistories->first();
                                    $historyClassroom = $activeHistory?->classroom;
                                    $historyClassName = $historyClassroom?->name ?? $className;
                                    $historyMajorName = $historyClassroom && $historyClassroom->major
                                        ? ($historyClassroom->major->code ?? $historyClassroom->major->name)
                                        : ($majorName ?? '-');
                                    $historyDateRange = $activeHistory && $activeHistory->start_date && $activeHistory->end_date
                                        ? $activeHistory->start_date->format('d M Y') . ' - ' . $activeHistory->end_date->format('d M Y')
                                        : '-';
                                    $historyEvent = $activeHistory?->event_type ?? '-';

                                    $cameraTypeValue = $room->camera_type ?? 'none';
                                    $cameraLabel = match ($cameraTypeValue) {
                                        'webcam' => 'Webcam Laptop',
                                        'ip_camera' => 'IP Camera',
                                        default => 'Tidak Ada',
                                    };
                                    $isCameraActive = (bool) ($room->is_camera_active ?? true);
                                    $cameraStatus = $isCameraActive ? 'Aktif' : 'Nonaktif';
                                    $hasIpPreview = $cameraTypeValue === 'ip_camera' && $isCameraActive && filled($room->stream_url);
                                    $hasWebcamPreview = $cameraTypeValue === 'webcam' && $isCameraActive;
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 align-top">
                                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ ($rooms->firstItem() ?? 1) + $loop->index }}
                                    </td>
                                    <td class="px-3 py-4">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate max-w-[170px]">{{ $room->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-[170px]">{{ $room->code }}</p>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <span class="block truncate max-w-[120px]">{{ optional($room->building)->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-3 py-4">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 truncate max-w-[170px]">{{ $className }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-[170px]">{{ $majorName ?? '-' }}</p>
                                    </td>
                                    <td class="px-3 py-4">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 truncate max-w-[170px]">{{ $teacherName }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate max-w-[170px]">{{ $subjectName }}</p>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                        {{ $timeRange }}
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="space-y-1">
                                            <span
                                                class="{{ $cameraTypeValue === 'ip_camera' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' : ($cameraTypeValue === 'webcam' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300') }} inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold">
                                                {{ $cameraLabel }}
                                            </span>
                                            <p class="text-xs {{ $isCameraActive ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                                {{ $cameraStatus }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        @if ($hasIpPreview)
                                            <div class="relative w-[170px] h-[96px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
                                                <img src="{{ $room->stream_url }}" alt="Preview {{ $room->name }}"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                                                <div style="display:none;" class="absolute inset-0 items-center justify-center text-xs text-gray-500 dark:text-gray-400">
                                                    Stream tidak tersedia
                                                </div>
                                            </div>
                                        @elseif ($hasWebcamPreview)
                                            <div class="relative w-[170px] h-[96px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-black">
                                                <video
                                                    class="webcam-preview-video w-full h-full object-cover"
                                                    autoplay
                                                    muted
                                                    playsinline
                                                ></video>
                                                <div class="webcam-preview-overlay absolute inset-0 flex items-center justify-center text-[11px] text-white/80 text-center px-2 bg-black/40">
                                                    Mengaktifkan webcam...
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-[170px] h-[96px] rounded-lg border border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center text-xs text-gray-500 dark:text-gray-400 px-3 text-center">
                                                Tidak ada preview kamera
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4">
                                        @if ($entry)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                                Sedang Dipakai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                Tidak Dipakai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
                                            <button
                                                type="button"
                                                class="open-monitor-btn inline-flex items-center px-3 py-1.5 rounded-md border border-blue-300 dark:border-blue-600 bg-blue-50 dark:bg-blue-900/20 text-xs font-medium text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/30"
                                                data-room="{{ $room->name }}"
                                                data-building="{{ optional($room->building)->name ?? '-' }}"
                                                data-camera-type="{{ $cameraTypeValue }}"
                                                data-stream-url="{{ $room->stream_url }}"
                                                data-camera-active="{{ $isCameraActive ? '1' : '0' }}"
                                                data-history-class="{{ $historyClassName ?? '-' }}"
                                                data-history-major="{{ $historyMajorName ?? '-' }}"
                                                data-history-period="{{ $historyDateRange }}"
                                                data-history-event="{{ $historyEvent }}">
                                                Pantau
                                            </button>
                                            <a href="{{ route('admin.cctv.settings.index', ['search' => $room->name]) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                Konfigurasi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada data ruangan yang sesuai filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($rooms->total() > 0)
                    @php
                        $currentPage = $rooms->currentPage();
                        $lastPage = $rooms->lastPage();
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);
                    @endphp

                    <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                            <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                <p>Menampilkan {{ $rooms->firstItem() }} - {{ $rooms->lastItem() }} dari {{ $rooms->total() }} data</p>
                                <p>Halaman {{ $currentPage }} dari {{ $lastPage }}</p>
                            </div>

                            <div class="flex items-center flex-wrap gap-2">
                                <a href="{{ $rooms->url(1) }}"
                                    class="{{ $rooms->onFirstPage() ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Pertama
                                </a>

                                <a href="{{ $rooms->previousPageUrl() ?? '#' }}"
                                    class="{{ $rooms->onFirstPage() ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Sebelumnya
                                </a>

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    <a href="{{ $rooms->url($page) }}"
                                        class="{{ $page === $currentPage ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white dark:bg-gray-900/50 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} inline-flex items-center justify-center w-9 h-9 rounded-md border text-xs font-semibold">
                                        {{ $page }}
                                    </a>
                                @endfor

                                <a href="{{ $rooms->nextPageUrl() ?? '#' }}"
                                    class="{{ $rooms->hasMorePages() ? '' : 'pointer-events-none opacity-50' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Berikutnya
                                </a>

                                <a href="{{ $rooms->url($lastPage) }}"
                                    class="{{ $currentPage === $lastPage ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Terakhir
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="monitor-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/60 p-4">
        <div class="w-full max-w-5xl rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900/50 shadow-2xl overflow-hidden">
            <div class="flex items-start justify-between gap-3 p-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h4 id="monitor-room-name" class="text-base font-semibold text-gray-900 dark:text-gray-100">Pantau Kamera</h4>
                    <p id="monitor-building-name" class="text-sm text-gray-500 dark:text-gray-400">-</p>
                </div>
                <button
                    id="monitor-close-btn"
                    type="button"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <span class="sr-only">Tutup</span>
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
            <div class="p-4">
                <div id="monitor-empty-state" class="hidden rounded-lg border border-dashed border-gray-300 dark:border-gray-600 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    Kamera tidak aktif atau belum dikonfigurasi untuk ruangan ini.
                </div>

                <div id="monitor-ip-wrapper" class="hidden">
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-black aspect-video">
                        <img id="monitor-ip-frame" src="" alt="Stream kamera" class="w-full h-full object-cover">
                    </div>
                </div>

                <div id="monitor-webcam-wrapper" class="hidden">
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-black aspect-video">
                        <video id="monitor-webcam-video" class="w-full h-full object-cover" autoplay muted playsinline></video>
                        <div id="monitor-webcam-overlay" class="absolute inset-0 flex items-center justify-center text-xs text-white/90 bg-black/40 px-3 text-center">
                            Mengaktifkan webcam...
                        </div>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-3">
                        <p class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Kelas saat ini</p>
                        <p id="monitor-info-class" class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">-</p>
                        <p id="monitor-info-major" class="text-xs text-gray-600 dark:text-gray-400">-</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-3">
                        <p class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400">Periode saat ini</p>
                        <p id="monitor-info-period" class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">-</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Event: <span id="monitor-info-event">-</span></p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @vite('resources/js/admin/cctv-index.js')
</x-app-layout>
