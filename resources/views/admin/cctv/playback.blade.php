<x-app-layout title="Playback Rekaman CCTV" description="Putar ulang rekaman CCTV berdasarkan tanggal dan waktu">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Playback Rekaman CCTV
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="space-y-6">
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <a href="{{ route('admin.cctv.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                    Kembali
                </a>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pilih Ruangan & Tanggal</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pilih ruangan dan tanggal untuk melihat rekaman CCTV</p>
                </div>

                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <form method="GET" action="{{ route('admin.cctv.playback.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">
                        <div>
                            <label for="building_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gedung</label>
                            <select name="building_id" id="building_id"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                                <option value="all" @selected($buildingId === 'all')>Semua Gedung</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" @selected($buildingId === (string) $building->id)>
                                        {{ $building->code }} - {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Kamera</label>
                            <select name="status" id="status"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                                <option value="all" @selected($status === 'all')>Semua Status</option>
                                <option value="online" @selected($status === 'online')>Online</option>
                                <option value="degraded" @selected($status === 'degraded')>Degraded</option>
                                <option value="offline" @selected($status === 'offline')>Offline</option>
                                <option value="unknown" @selected($status === 'unknown')>Unknown</option>
                            </select>
                        </div>

                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ruangan</label>
                            <select name="room_id" id="room_id"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                                <option value="">Pilih Ruangan</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @selected($roomId === (string) $room->id)>
                                        {{ $room->name }} - {{ optional($room->building)->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($rooms->isEmpty())
                                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                                    Tidak ada ruangan sesuai filter saat ini.
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ $date }}" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <x-heroicon-o-magnifying-glass class="w-4 h-4 mr-2" />
                                Cari Rekaman
                            </button>

                            @if ($buildingId !== 'all' || $status !== 'all')
                                <a href="{{ route('admin.cctv.playback.index', ['room_id' => $roomId, 'date' => $date]) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($selectedRoom)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $selectedRoom->name }}</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ optional($selectedRoom->building)->name }} - {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tipe Kamera</p>
                                @php
                                    $selectedRoomCameraLabel = match ($selectedRoom->camera_type ?? 'none') {
                                        'ip_camera' => 'IP Camera',
                                        'webcam' => 'Webcam Laptop',
                                        default => 'Tidak Ada',
                                    };
                                @endphp
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $selectedRoomCameraLabel }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div id="playback-player" class="mb-6">
                            <div class="relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-black aspect-video">
                                <div id="player-placeholder" class="absolute inset-0 flex items-center justify-center text-white">
                                    <div class="text-center">
                                        <x-heroicon-o-play-circle class="w-16 h-16 mx-auto mb-3 opacity-50" />
                                        <p class="text-sm">Pilih segment pada timeline untuk memutar rekaman</p>
                                    </div>
                                </div>
                                <video id="playback-video" class="hidden w-full h-full" controls></video>
                            </div>
                        </div>

                        <div id="timeline-container" class="space-y-4">
                            <div class="flex items-center justify-between gap-3">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Timeline Rekaman (24 Jam)</h4>
                                <div class="flex items-center gap-3">
                                    <p id="timeline-summary" class="text-xs text-gray-500 dark:text-gray-400">Memuat data timeline...</p>
                                    <div id="timeline-loading" class="hidden text-xs text-gray-500 dark:text-gray-400">
                                        Memuat timeline...
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-3">
                                <div class="overflow-x-auto">
                                    <div id="timeline-grid" class="grid gap-1 h-16 min-w-[760px]" style="grid-template-columns: repeat(24, minmax(0, 1fr));">
                                        <!-- Timeline akan diisi oleh JavaScript -->
                                    </div>
                                    <div id="timeline-hour-labels" class="grid gap-1 min-w-[760px] mt-2 text-[10px] text-gray-500 dark:text-gray-400" style="grid-template-columns: repeat(24, minmax(0, 1fr));">
                                        <!-- Label jam akan diisi oleh JavaScript -->
                                    </div>
                                </div>
                                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    Klik blok berwarna hijau untuk memutar rekaman pada jam tersebut.
                                </p>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <div class="flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2">
                                    <div class="w-3 h-3 bg-green-500 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Tersedia</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2">
                                    <div class="w-3 h-3 bg-gray-300 dark:bg-gray-600 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Tidak Ada</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2">
                                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Offline</span>
                                </div>
                                <div class="flex items-center gap-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2">
                                    <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                                    <span class="text-gray-600 dark:text-gray-400">Event</span>
                                </div>
                            </div>
                        </div>

                        <div id="segment-info" class="mt-6 p-4 bg-gray-50 dark:bg-gray-900/30 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Informasi Segmen Terpilih</h4>
                                <span id="segment-state-badge" class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                    Belum dipilih
                                </span>
                            </div>
                            <p id="segment-empty-hint" class="mb-4 text-xs text-gray-500 dark:text-gray-400">
                                Pilih blok jam berwarna hijau pada timeline untuk melihat detail segmen.
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Waktu Mulai</p>
                                    <p id="segment-start" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Waktu Selesai</p>
                                    <p id="segment-end" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Durasi</p>
                                    <p id="segment-duration" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Ukuran File</p>
                                    <p id="segment-size" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Mode Rekam</p>
                                    <p id="segment-mode" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Codec</p>
                                    <p id="segment-codec" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Resolusi</p>
                                    <p id="segment-resolution" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Integrity</p>
                                    <p id="segment-integrity" class="font-medium text-gray-900 dark:text-gray-100">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($selectedRoom)
        <script>
            window.roomId = @json($roomId);
            window.date = @json($date);
        </script>
        @vite('resources/js/admin/cctv-playback.js')
    @endif
</x-app-layout>
