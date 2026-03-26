<x-app-layout title="Status Kesehatan Kamera" description="Monitor status dan kesehatan kamera CCTV">
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Status Kesehatan Kamera
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6" id="cctv-health-page" data-summary-url="{{ route('admin.cctv.health.summary') }}">
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
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Ringkasan Status</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Status kesehatan kamera secara keseluruhan</p>
                </div>

                <div class="p-4 bg-gray-50/70 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-3" id="health-summary">
                        <div class="rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Total Kamera</p>
                            <p class="mt-2 text-2xl font-bold text-blue-900 dark:text-blue-100" id="stat-total">-</p>
                        </div>
                        <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-700 dark:text-green-300">Online</p>
                            <p class="mt-2 text-2xl font-bold text-green-900 dark:text-green-100" id="stat-online">-</p>
                        </div>
                        <div class="rounded-xl border border-yellow-200 dark:border-yellow-800 bg-yellow-50 dark:bg-yellow-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-yellow-700 dark:text-yellow-300">Degraded</p>
                            <p class="mt-2 text-2xl font-bold text-yellow-900 dark:text-yellow-100" id="stat-degraded">-</p>
                        </div>
                        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-700 dark:text-red-300">Offline</p>
                            <p class="mt-2 text-2xl font-bold text-red-900 dark:text-red-100" id="stat-offline">-</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Unknown</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100" id="stat-unknown">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Kamera</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Status detail setiap kamera</p>
                </div>

                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <form method="GET" action="{{ route('admin.cctv.health.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <select name="building_id"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($buildingId === 'all')>Semua Gedung</option>
                            @foreach ($buildings as $building)
                                <option value="{{ $building->id }}" @selected($buildingId === (string) $building->id)>
                                    {{ $building->code }} - {{ $building->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($status === 'all')>Semua Status</option>
                            <option value="online" @selected($status === 'online')>Online</option>
                            <option value="degraded" @selected($status === 'degraded')>Degraded</option>
                            <option value="offline" @selected($status === 'offline')>Offline</option>
                            <option value="unknown" @selected($status === 'unknown')>Unknown</option>
                        </select>

                        <select name="per_page"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="10" @selected($perPage === 10)>10 / halaman</option>
                            <option value="15" @selected($perPage === 15)>15 / halaman</option>
                            <option value="25" @selected($perPage === 25)>25 / halaman</option>
                            <option value="50" @selected($perPage === 50)>50 / halaman</option>
                        </select>

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Terapkan Filter
                            </button>

                            @if ($buildingId !== 'all' || $status !== 'all' || $perPage !== 10)
                                <a href="{{ route('admin.cctv.health.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
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
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Ruangan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Gedung</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Tipe Kamera</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Terakhir Cek</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Response Time</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Error</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($rooms as $room)
                                @php
                                    $healthLog = $room->latestHealthLog;
                                    $statusValue = $healthLog?->status ?? 'unknown';
                                    $statusBadge = match($statusValue) {
                                        'online' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                                        'degraded' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'offline' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                    $statusLabel = match($statusValue) {
                                        'online' => 'Online',
                                        'degraded' => 'Degraded',
                                        'offline' => 'Offline',
                                        default => 'Unknown',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-4 py-4">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $room->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $room->code }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ optional($room->building)->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        @php
                                            $cameraTypeValue = $room->camera_type ?? 'none';
                                            $cameraTypeClass = match($cameraTypeValue) {
                                                'ip_camera' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
                                                'webcam' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                            };
                                            $cameraTypeLabel = match($cameraTypeValue) {
                                                'ip_camera' => 'IP Camera',
                                                'webcam' => 'Webcam',
                                                default => 'Tidak Ada',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $cameraTypeClass }}">
                                            {{ $cameraTypeLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $statusBadge }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $healthLog ? $healthLog->checked_at->diffForHumans() : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $healthLog && $healthLog->response_ms ? $healthLog->response_ms . ' ms' : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        @if ($healthLog && $healthLog->error_message)
                                            <span class="text-xs text-red-600 dark:text-red-400" title="{{ $healthLog->error_message }}">
                                                {{ Str::limit($healthLog->error_message, 30) }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada data kamera yang sesuai filter.
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
                                    class="{{ $rooms->onFirstPage() ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Pertama
                                </a>

                                <a href="{{ $rooms->previousPageUrl() ?? '#' }}"
                                    class="{{ $rooms->onFirstPage() ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Sebelumnya
                                </a>

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    <a href="{{ $rooms->url($page) }}"
                                        class="{{ $page === $currentPage ? 'bg-blue-600 border-blue-600 text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} inline-flex items-center justify-center w-9 h-9 rounded-md border text-xs font-semibold">
                                        {{ $page }}
                                    </a>
                                @endfor

                                <a href="{{ $rooms->nextPageUrl() ?? '#' }}"
                                    class="{{ $rooms->hasMorePages() ? '' : 'pointer-events-none opacity-50' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Berikutnya
                                </a>

                                <a href="{{ $rooms->url($lastPage) }}"
                                    class="{{ $currentPage === $lastPage ? 'pointer-events-none opacity-50' : '' }} inline-flex items-center px-3 py-1.5 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    Terakhir
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @vite('resources/js/admin/cctv-health.js')
</x-app-layout>
