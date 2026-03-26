<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gedung & Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-900/50 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Manajemen Gedung & Ruangan</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola infrastruktur fisik sekolah, gedung, dan setiap ruangan di dalamnya.</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <x-secondary-button x-data=""
                            class="bg-white dark:bg-gray-900/50"
                            x-on:click.prevent="$dispatch('open-modal', 'add-building-modal')">
                            <x-heroicon-o-building-office class="w-4 h-4 mr-2" />
                            Tambah Gedung
                        </x-secondary-button>
                        <button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'add-room-modal')"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            Tambah Ruangan
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/70 dark:bg-gray-900/40">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div class="rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-blue-700 dark:text-blue-300">Total Gedung</p>
                            <p class="mt-2 text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $totalBuildings }}</p>
                        </div>
                        <div class="rounded-xl border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">Total Ruangan</p>
                            <p class="mt-2 text-2xl font-bold text-indigo-900 dark:text-indigo-100">{{ $totalRooms }}</p>
                        </div>
                        <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-green-700 dark:text-green-300">Ruangan Aktif</p>
                            <p class="mt-2 text-2xl font-bold text-green-900 dark:text-green-100">{{ $activeRooms }}</p>
                        </div>
                        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-red-700 dark:text-red-300">Nonaktif</p>
                            <p class="mt-2 text-2xl font-bold text-red-900 dark:text-red-100">{{ $inactiveRooms }}</p>
                        </div>
                    </div>
                </div>

                <!-- Search & Filters -->
                <div class="p-4 bg-gray-50/70 dark:bg-gray-900/40">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-400" />
                            </div>
                            <input type="text" id="searchInput" placeholder="Cari nama gedung atau ruangan..."
                                class="pl-10 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="w-full md:w-48">
                            <select id="typeFilter"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 text-sm">
                                <option value="">Semua Tipe</option>
                                @foreach ($roomTypes as $type)
                                    <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            <div class="space-y-3">
                @if (session('success'))
                    <div id="successAlert"
                        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <x-heroicon-o-check-circle
                                class="w-5 h-5 text-green-600 dark:text-green-400 mr-3 flex-shrink-0" />
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div id="errorAlert"
                        class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-center">
                            <x-heroicon-o-x-circle class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 flex-shrink-0" />
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div id="validationAlert"
                        class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <x-heroicon-o-exclamation-triangle
                                class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5 flex-shrink-0" />
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
            </div>

            <!-- Buildings with Rooms -->
            <div class="space-y-4">
                @forelse($buildings as $building)
                    <div class="bg-white dark:bg-gray-900/50 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden building-card"
                        data-building-name="{{ strtolower($building->name) }}"
                        data-building-code="{{ strtolower($building->code) }}">
                        
                        <!-- Building Header -->
                        <div class="p-4 cursor-pointer hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors"
                            onclick="toggleBuilding('{{ $building->id }}')">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                                            <x-heroicon-o-building-office class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-gray-400 uppercase tracking-tighter">{{ $building->code }}</span>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                                {{ $building->name }}
                                            </h3>
                                        </div>
                                        <div class="flex items-center gap-3 mt-0.5">
                                            <span class="inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                                {{-- <x-heroicon-o-layers class="w-3.5 h-3.5 mr-1" /> --}}
                                                {{ $building->total_floors }} Lantai
                                            </span>
                                            <span class="inline-flex items-center text-xs font-medium text-gray-500 dark:text-gray-400">
                                                {{-- <x-heroicon-o-cube class="w-3.5 h-3.5 mr-1" /> --}}
                                                {{ $building->rooms_count }} Ruangan
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                    <button onclick="editBuilding('{{ $building->id }}')"
                                        class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition-colors border border-transparent hover:border-amber-200 dark:hover:border-amber-800"
                                        title="Edit Gedung">
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </button>
                                    <button
                                        onclick="deleteBuilding('{{ $building->id }}', '{{ $building->name }}')"
                                        class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors border border-transparent hover:border-red-200 dark:hover:border-red-800"
                                        title="Hapus Gedung">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                    <div class="w-px h-8 bg-gray-200 dark:bg-gray-700 mx-1"></div>
                                    <x-heroicon-o-chevron-down id="chevron-{{ $building->id }}"
                                        class="w-6 h-6 text-gray-400 transition-transform duration-300" />
                                </div>
                            </div>
                        </div>

                        <!-- Rooms Table (Collapsible) -->
                        <div id="rooms-{{ $building->id }}"
                            class="hidden border-t border-gray-200 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-900/20">
                            @if ($building->rooms->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-100/50 dark:bg-gray-800/30">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ruangan</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lantai</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kapasitas</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($building->rooms as $room)
                                                <tr class="hover:bg-white dark:hover:bg-gray-800/50 transition-colors room-row"
                                                    data-room-name="{{ strtolower($room->name) }}"
                                                    data-room-code="{{ strtolower($room->code) }}"
                                                    data-room-type="{{ $room->type }}">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $room->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $room->code }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                        <span class="inline-flex items-center">
                                                            <x-heroicon-m-chevron-double-up class="w-3.5 h-3.5 mr-1 text-gray-300" />
                                                            {{ $room->floor ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                        <span class="inline-flex items-center">
                                                            <x-heroicon-m-users class="w-3.5 h-3.5 mr-1.5 text-gray-300" />
                                                            {{ $room->capacity ?? '-' }} Siswa
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap uppercase tracking-tighter">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                                            {{ $room->type }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $room->is_active ? 'bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 border border-green-100 dark:border-green-800' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700' }}">
                                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $room->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                                            {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex items-center justify-end gap-2">
                                                            <button onclick="viewRoom('{{ $room->id }}')"
                                                                class="p-1.5 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-md transition-colors"
                                                                title="Lihat Detail">
                                                                <x-heroicon-o-eye class="w-5 h-5" />
                                                            </button>
                                                            <button onclick="editRoom('{{ $room->id }}')"
                                                                class="p-1.5 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-md transition-colors"
                                                                title="Edit">
                                                                <x-heroicon-o-pencil class="w-5 h-5" />
                                                            </button>
                                                            <button
                                                                onclick="deleteRoom('{{ $room->id }}', '{{ $room->name }}')"
                                                                class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-colors"
                                                                title="Hapus">
                                                                <x-heroicon-o-trash class="w-5 h-5" />
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <x-heroicon-o-cube-transparent class="w-10 h-10 mx-auto mb-3 text-gray-300 dark:text-gray-600" />
                                    <p class="text-sm">Belum ada ruangan yang ditambahkan ke gedung ini</p>
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-room-modal')"
                                        class="mt-3 text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                        Klik untuk menambah ruangan
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900/50 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-16 text-center">
                            <x-heroicon-o-building-office class="w-16 h-16 text-gray-300 dark:text-gray-700 mx-auto mb-4" />
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Belum ada data gedung</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400 max-w-sm mx-auto">Sistem memerlukan setidaknya satu gedung sebelum Anda dapat membuat ruangan kelas.</p>
                            <div class="mt-8">
                                <button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'add-building-modal')"
                                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/30 transition-all duration-200">
                                    <x-heroicon-o-plus class="h-5 w-5 mr-2" />
                                    Mulai Tambah Gedung
                                </button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($undefinedRooms->count() > 0)
                <!-- Unassigned Rooms -->
                <div class="bg-amber-50/30 dark:bg-amber-900/10 rounded-xl border border-amber-200 dark:border-amber-800/50 overflow-hidden shadow-sm">
                    <div class="p-4 flex items-center gap-4 bg-amber-50/50 dark:bg-amber-900/20">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center border border-amber-200 dark:border-amber-700">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-amber-600 dark:text-amber-500" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-amber-900 dark:text-amber-100 italic">Ruangan Tanpa Alokasi Gedung</h3>
                            <p class="text-xs text-amber-700/70 dark:text-amber-400/70">
                                Ditemukan {{ $undefinedRooms->count() }} ruangan yang datanya tidak terikat pada gedung manapun.
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-amber-200 dark:border-amber-800/50">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-amber-200 dark:divide-amber-800/50">
                                <thead class="bg-amber-50/30 dark:bg-amber-900/10">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-amber-700 dark:text-amber-500 uppercase tracking-wider">Ruangan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-amber-700 dark:text-amber-500 uppercase tracking-wider">Lantai</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-amber-700 dark:text-amber-500 uppercase tracking-wider">Kapasitas</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-amber-700 dark:text-amber-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-200 dark:divide-amber-800/50">
                                    @foreach ($undefinedRooms as $room)
                                        <tr class="hover:bg-amber-50/50 dark:hover:bg-amber-900/10 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-amber-900 dark:text-amber-100">{{ $room->name }}</div>
                                                <div class="text-xs text-amber-700 dark:text-amber-400">{{ $room->code }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-800 dark:text-amber-200">{{ $room->floor ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-800 dark:text-amber-200">{{ $room->capacity ?? '-' }} Siswa</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <div class="flex items-center gap-2">
                                                    <button onclick="editRoom('{{ $room->id }}')"
                                                        class="px-3 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 rounded text-xs font-bold hover:bg-amber-200 dark:hover:bg-amber-900/60 transition-colors border border-amber-200 dark:border-amber-700">
                                                        Atur Gedung
                                                    </button>
                                                    <button onclick="deleteRoom('{{ $room->id }}', '{{ $room->name }}')"
                                                        class="p-1.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-md">
                                                        <x-heroicon-o-trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>



    <!-- Add Building Modal -->
    <x-modal name="add-building-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Tambah Gedung Baru') }}
                </h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form method="POST" action="{{ route('admin.buildings.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Gedung
                        *</label>
                    <x-text-input name="code" type="text" class="block w-full" :value="old('code')" required
                        autofocus placeholder="Contoh: GDA" />
                    <x-input-error class="mt-2" :messages="$errors->get('code')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Gedung
                        *</label>
                    <x-text-input name="name" type="text" class="block w-full" :value="old('name')" required
                        placeholder="Contoh: Gedung A" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Lantai
                        *</label>
                    <x-text-input name="total_floors" type="number" class="block w-full" :value="old('total_floors', 1)" required
                        min="1" />
                    <x-input-error class="mt-2" :messages="$errors->get('total_floors')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Deskripsi gedung (opsional)">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors">
                        Simpan Gedung
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Edit Building Modal -->
    <x-modal name="edit-building-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Edit Gedung
                </h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form id="editBuildingForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Gedung
                        *</label>
                    <x-text-input id="editBuildingCode" name="code" type="text" class="block w-full"
                        required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Gedung
                        *</label>
                    <x-text-input id="editBuildingName" name="name" type="text" class="block w-full"
                        required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Lantai
                        *</label>
                    <x-text-input id="editBuildingFloors" name="total_floors" type="number" class="block w-full"
                        required min="1" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea id="editBuildingDescription" name="description" rows="2"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Building Modal -->
    <x-modal name="delete-building-modal" focusable>
        <div class="p-6">
            <div class="flex items-start mb-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 dark:text-red-400" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Hapus Gedung
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Apakah Anda yakin ingin menghapus gedung <span id="deleteBuildingName" class="font-bold text-gray-900 dark:text-white underline decoration-red-500/30"></span>?
                        Tindakan ini permanen dan gedung hanya dapat dihapus jika sudah tidak memiliki ruangan di dalamnya.
                    </p>
                </div>
            </div>

            <form id="deleteBuildingForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-red-500">
                        Hapus Gedung
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Add Room Modal -->
    <x-modal name="add-room-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Tambah Ruangan Baru') }}
                </h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="p-2 rounded-full text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kode Ruangan <span class="text-red-500">*</span></label>
                        <x-text-input name="code" type="text" class="block w-full" :value="old('code')" required placeholder="Misal: R101" />
                        <x-input-error class="mt-1" :messages="$errors->get('code')" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Ruangan <span class="text-red-500">*</span></label>
                        <x-text-input name="name" type="text" class="block w-full" :value="old('name')" required placeholder="Misal: Ruang Kelas X-1" />
                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Gedung / Lokasi <span class="text-red-500">*</span></label>
                    <x-select-input name="building_id" required>
                        <option value="">-- Pilih Gedung --</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->code }} - {{ $building->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                    <x-input-error class="mt-1" :messages="$errors->get('building_id')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Lantai</label>
                        <x-text-input name="floor" type="number" class="block w-full" :value="old('floor')" min="0" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kapasitas (Siswa)</label>
                        <x-text-input name="capacity" type="number" class="block w-full" :value="old('capacity')" min="0" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tipe Ruangan <span class="text-red-500">*</span></label>
                        <x-select-input name="type" required>
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </x-select-input>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Catatan Tambahan</label>
                    <textarea name="notes" rows="2"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        placeholder="Detail fasilitas atau informasi lainnya...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                    <input type="checkbox" name="is_active" id="addIsActive" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 transition-colors">
                    <label for="addIsActive" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Aktifkan Ruangan (Dapat digunakan dalam jadwal)
                    </label>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-indigo-500">
                        Simpan Ruangan
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- View Room Modal -->
    <x-modal name="view-room-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <x-heroicon-o-cube class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    Detail Ruangan
                </h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="p-2 rounded-full text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <div id="viewRoomContent" class="space-y-6">
                <!-- Content will be loaded via JavaScript -->
            </div>
        </div>
    </x-modal>

    <!-- Edit Room Modal -->
    <x-modal name="edit-room-modal" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                    <x-heroicon-o-pencil-square class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    Edit Ruangan
                </h2>
                <button type="button" x-on:click="$dispatch('close')"
                    class="p-2 rounded-full text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>

            <form id="editRoomForm" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kode Ruangan <span class="text-red-500">*</span></label>
                        <x-text-input id="editRoomCode" name="code" type="text" class="block w-full" required />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Ruangan <span class="text-red-500">*</span></label>
                        <x-text-input id="editRoomName" name="name" type="text" class="block w-full" required />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Gedung / Lokasi <span class="text-red-500">*</span></label>
                    <x-select-input id="editRoomBuilding" name="building_id" required>
                        <option value="">-- Pilih Gedung --</option>
                        @foreach ($buildings as $building)
                            <option value="{{ $building->id }}">
                                {{ $building->code }} - {{ $building->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Lantai</label>
                        <x-text-input id="editRoomFloor" name="floor" type="number" class="block w-full" min="0" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Kapasitas</label>
                        <x-text-input id="editRoomCapacity" name="capacity" type="number" class="block w-full" min="0" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tipe Ruangan <span class="text-red-500">*</span></label>
                        <x-select-input id="editRoomType" name="type" required>
                            @foreach ($roomTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </x-select-input>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Catatan</label>
                    <textarea id="editRoomNotes" name="notes" rows="2"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                </div>

                <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                    <input type="checkbox" name="is_active" id="editIsActive" value="1"
                        class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-900 transition-colors">
                    <label for="editIsActive" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Ruangan aktif</label>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Room Modal -->
    <x-modal name="delete-room-modal" focusable>
        <div class="p-6">
            <div class="flex items-start mb-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 dark:text-red-400" />
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Hapus Ruangan
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        Apakah Anda yakin ingin menghapus ruangan <span id="deleteRoomName" class="font-bold text-gray-900 dark:text-white underline decoration-red-500/30"></span>?
                        Tindakan ini permanen dan tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <form id="deleteRoomForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="bg-gray-50 dark:bg-gray-900/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 -mx-6 -mb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-red-500">
                        Hapus Ruangan
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    @vite(['resources/js/admin/room-index.js'])
</x-app-layout>
