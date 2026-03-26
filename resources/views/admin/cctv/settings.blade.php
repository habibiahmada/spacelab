<x-app-layout title="Pengaturan Kamera CCTV" description="Atur tipe kamera dan stream URL per ruangan">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Pengaturan Kamera CCTV
            </h2>
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

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $configuredCount }} dari {{ $totalFiltered }} ruangan sudah dikonfigurasi
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <x-heroicon-o-check-circle class="w-5 h-5 text-green-600 dark:text-green-400 mr-3 flex-shrink-0" />
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <x-heroicon-o-x-circle class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 flex-shrink-0" />
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Terdapat kesalahan pada input:</p>
                            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Kamera per Ruangan</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Data diambil langsung dari database ruangan.</p>
                </div>

                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                        <div class="rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Total Hasil Filter</p>
                            <p class="mt-2 text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $totalFiltered }}</p>
                        </div>
                        <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-700 dark:text-green-300">Kamera Aktif</p>
                            <p class="mt-2 text-2xl font-bold text-green-900 dark:text-green-100">{{ $activeCount }}</p>
                        </div>
                        <div class="rounded-xl border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">IP Camera</p>
                            <p class="mt-2 text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $ipCameraCount }}</p>
                        </div>
                        <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-300">Tanpa Kamera</p>
                            <p class="mt-2 text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $noCameraCount }}</p>
                        </div>
                    </div>
                </div>


                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <form method="GET" action="{{ route('admin.cctv.settings.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-3">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama ruangan, kode, atau gedung..."
                            class="xl:col-span-2 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">

                        <select name="camera_type"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($cameraType === 'all')>Semua Tipe Kamera</option>
                            <option value="none" @selected($cameraType === 'none')>Tidak Ada</option>
                            <option value="webcam" @selected($cameraType === 'webcam')>Webcam Laptop</option>
                            <option value="ip_camera" @selected($cameraType === 'ip_camera')>IP Camera</option>
                        </select>

                        <select name="camera_status"
                            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                            <option value="all" @selected($cameraStatus === 'all')>Semua Status</option>
                            <option value="active" @selected($cameraStatus === 'active')>Aktif</option>
                            <option value="inactive" @selected($cameraStatus === 'inactive')>Nonaktif</option>
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
                                    $cameraStatus !== 'all' ||
                                    $buildingId !== 'all' ||
                                    $perPage !== 10)
                                <a href="{{ route('admin.cctv.settings.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 w-16">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[220px]">Ruangan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[180px]">Gedung</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[180px]">Tipe Kamera</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[260px]">URL Stream</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[130px]">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300 min-w-[140px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($rooms as $room)
                                @php
                                    $isOldRoom = (string) old('room_id') === (string) $room->id;
                                    $roomCameraType = $isOldRoom ? old('camera_type', $room->camera_type ?? 'none') : ($room->camera_type ?? 'none');
                                    $roomStreamUrl = $isOldRoom ? old('stream_url', $room->stream_url ?? '') : ($room->stream_url ?? '');
                                    $roomIsCameraActive = $isOldRoom ? (bool) old('is_camera_active') : (bool) ($room->is_camera_active ?? true);
                                    $formId = 'room-form-' . $room->id;
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 align-top">
                                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ ($rooms->firstItem() ?? 1) + $loop->index }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <form id="{{ $formId }}" method="POST" action="{{ route('admin.cctv.settings') }}" class="hidden">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="search" value="{{ $search }}">
                                            <input type="hidden" name="filter_camera_type" value="{{ $cameraType }}">
                                            <input type="hidden" name="filter_camera_status" value="{{ $cameraStatus }}">
                                            <input type="hidden" name="filter_building_id" value="{{ $buildingId }}">
                                            <input type="hidden" name="filter_per_page" value="{{ $perPage }}">
                                            <input type="hidden" name="filter_page" value="{{ $rooms->currentPage() }}">
                                        </form>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $room->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $room->code }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ optional($room->building)->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <select name="camera_type" form="{{ $formId }}"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                                            <option value="none" @selected($roomCameraType === 'none')>Tidak Ada</option>
                                            <option value="webcam" @selected($roomCameraType === 'webcam')>Webcam Laptop</option>
                                            <option value="ip_camera" @selected($roomCameraType === 'ip_camera')>IP Camera</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="url" name="stream_url" form="{{ $formId }}" value="{{ $roomStreamUrl }}" placeholder="http://192.168.1.x/stream"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-gray-500 dark:focus:border-gray-400 focus:ring-gray-500 dark:focus:ring-gray-400 text-sm">
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Wajib untuk tipe IP Camera.</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                            <input type="checkbox" name="is_camera_active" value="1" form="{{ $formId }}" @checked($roomIsCameraActive)
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                            Aktif
                                        </label>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <button type="submit" form="{{ $formId }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Simpan
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
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
</x-app-layout>
