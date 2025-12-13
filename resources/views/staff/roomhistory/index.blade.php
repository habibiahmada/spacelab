<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat & Status Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Section 1: Live Status - Compact Grid -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Ruangan Saat Ini</h3>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ count($rooms) }} Ruangan</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach ($rooms as $room)
                        @php
                            $isOccupied = $room->current_status === 'Occupied';
                            $entry = $room->current_entry;
                        @endphp
                        <div class="relative bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3 hover:shadow-md transition-shadow duration-200">
                            <!-- Status Indicator -->
                            <div class="absolute top-2 right-2">
                                <div class="w-2 h-2 rounded-full {{ $isOccupied ? 'bg-gray-400' : 'bg-gray-300' }}"></div>
                            </div>

                            <!-- Room Code -->
                            <div class="mb-2">
                                <h4 class="font-semibold text-base text-gray-900 dark:text-gray-100">
                                    {{ $room->code }}
                                </h4>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $isOccupied ? 'Terpakai' : 'Tersedia' }}
                                </span>
                            </div>

                            <!-- Details -->
                            @if ($isOccupied && $entry)
                                <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1 border-t border-gray-100 dark:border-gray-700 pt-2">
                                    <p class="font-medium text-gray-800 dark:text-gray-200 truncate">
                                        {{ $entry->teacherSubject?->subject?->name ?? 'N/A' }}
                                    </p>
                                    <p class="truncate">{{ $entry->roomHistory?->classroom?->full_name ?? 'N/A' }}</p>
                                    <p class="truncate">{{ $entry->teacherSubject?->teacher?->name ?? 'N/A' }}</p>
                                    <p class="text-gray-500 dark:text-gray-500">
                                        {{ $entry->period?->start_time }} - {{ $entry->period?->end_time }}
                                    </p>
                                </div>
                            @else
                                <p class="text-xs text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-100 dark:border-gray-700">
                                    Siap digunakan
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 2: History Table - Clean & Compact -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">Riwayat Penggunaan</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola alokasi dan riwayat ruangan</p>
                        </div>
                        <button onclick="openModal('create')"
                            class="inline-flex items-center px-3 py-2 bg-gray-900 dark:bg-gray-700 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-wider hover:bg-gray-800 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <x-heroicon-o-plus class="w-4 h-4 mr-1.5" />
                            Tambah
                        </button>
                    </div>
                </div>

                <!-- Responsive Table Wrapper -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Ruangan
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Kelas
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Guru
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Tahun Ajaran
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Tipe Event
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($histories as $history)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $history->room->code ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $history->classroom->full_name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $history->teacher->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            <div>{{ $history->term->tahun_ajaran ?? '-' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $history->term->kind ?? '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $history->event_type ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                        <button onclick="openModal('edit', {{ json_encode($history) }})"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 font-medium mr-3 transition-colors duration-150">
                                            Edit
                                        </button>
                                        <button onclick="confirmDelete('{{ $history->id }}')"
                                            class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 font-medium transition-colors duration-150">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                            <svg class="w-12 h-12 mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-sm">Tidak ada data riwayat penggunaan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Clean Design -->
    <x-modal name="historyModal" :show="false" focusable>
        <form id="historyForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100" id="modalTitle">Tambah Alokasi</h3>
            </div>

            <div class="px-6 py-4 space-y-4 max-h-[60vh] overflow-y-auto">
                <!-- Room -->
                <div>
                    <x-input-label for="room_id" value="Ruangan" class="text-sm" />
                    <select name="room_id" id="room_id"
                        class="mt-1.5 block w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-500 dark:focus:border-gray-500 focus:ring-gray-500 dark:focus:ring-gray-500 rounded-md shadow-sm">
                        <option value="">Pilih Ruangan</option>
                        @foreach ($allRooms as $r)
                            <option value="{{ $r->id }}">{{ $r->code }} - {{ $r->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                </div>

                <!-- Class -->
                <div>
                    <x-input-label for="classes_id" value="Kelas" class="text-sm" />
                    <select name="classes_id" id="classes_id"
                        class="mt-1.5 block w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-500 dark:focus:border-gray-500 focus:ring-gray-500 dark:focus:ring-gray-500 rounded-md shadow-sm">
                        <option value="">Pilih Kelas (Opsional)</option>
                        @foreach ($classrooms as $c)
                            <option value="{{ $c->id }}">{{ $c->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Teacher -->
                <div>
                    <x-input-label for="teacher_id" value="Guru" class="text-sm" />
                    <select name="teacher_id" id="teacher_id"
                        class="mt-1.5 block w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-500 dark:focus:border-gray-500 focus:ring-gray-500 dark:focus:ring-gray-500 rounded-md shadow-sm">
                        <option value="">Pilih Guru (Opsional)</option>
                        @foreach ($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Term -->
                <div>
                    <x-input-label for="terms_id" value="Tahun Ajaran" class="text-sm" />
                    <select name="terms_id" id="terms_id"
                        class="mt-1.5 block w-full text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-500 dark:focus:border-gray-500 focus:ring-gray-500 dark:focus:ring-gray-500 rounded-md shadow-sm">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" {{ $term->is_active ? 'selected' : '' }}>
                                {{ $term->tahun_ajaran }} - {{ ucfirst($term->kind) }}
                                {{ $term->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Type -->
                <div>
                    <x-input-label for="event_type" value="Tipe Event" class="text-sm" />
                    <x-text-input id="event_type" name="event_type" type="text" class="mt-1.5 block w-full text-sm"
                        placeholder="Contoh: KBM, Rapat, Ujian" />
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 flex justify-end gap-2 border-t border-gray-200 dark:border-gray-700">
                <button type="button" x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-medium text-xs text-gray-700 dark:text-gray-300 uppercase tracking-wider hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Batal
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-gray-900 dark:bg-gray-700 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-wider hover:bg-gray-800 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Simpan
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function openModal(mode, data = null) {
            const form = document.getElementById('historyForm');
            const title = document.getElementById('modalTitle');
            const methodInput = document.getElementById('formMethod');

            // Reset form
            form.reset();

            if (mode === 'create') {
                form.action = "{{ route('staff.rooms.history.store') }}";
                methodInput.value = 'POST';
                title.innerText = 'Tambah Alokasi';
            } else {
                form.action = `/staff/room-history/${data.id}`;
                methodInput.value = 'PUT';
                title.innerText = 'Edit Alokasi';

                // Fill data
                document.getElementById('room_id').value = data.room_id;
                document.getElementById('classes_id').value = data.classes_id;
                document.getElementById('teacher_id').value = data.teacher_id;
                document.getElementById('terms_id').value = data.terms_id;
                document.getElementById('event_type').value = data.event_type;
            }

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'historyModal'
            }));
        }

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
                const form = document.getElementById('deleteForm');
                form.action = `/staff/room-history/${id}`;
                form.submit();
            }
        }
    </script>
</x-app-layout>
