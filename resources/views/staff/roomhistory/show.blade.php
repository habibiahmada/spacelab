<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Kalender Ruangan') }}
            </h2>
            <a href="{{ route('staff.rooms.history') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                ← Kembali ke daftar ruangan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $room->code }} - {{ $room->name }}</h3>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- reuse the same modal for creating/editing history -->
    <x-modal name="historyModal" :show="false" focusable>
        <form id="historyForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-gray-800 dark:to-gray-800">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Tambah Alokasi Ruangan</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Lengkapi informasi alokasi ruangan</p>
            </div>

            <div class="px-6 py-5 space-y-5 max-h-[65vh] overflow-y-auto">
                <!-- Date & Time fields copied from index with slight modifications -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                    <div>
                        <x-input-label for="start_datetime" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal & Jam Mulai <span class="text-red-500">*</span>
                            </div>
                        </x-input-label>
                        <input id="start_datetime" name="start_date" type="datetime-local" required
                            class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="end_datetime" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal & Jam Selesai <span class="text-red-500">*</span>
                            </div>
                        </x-input-label>
                        <input id="end_datetime" name="end_date" type="datetime-local" required
                            class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>

                <!-- other fields (class, teacher, term) copied from index modal -->
                <div>
                    <x-input-label for="classes_id" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 a 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Kelas <span class="text-gray-400 text-xs">(Opsional)</span>
                        </div>
                    </x-input-label>
                    <select name="classes_id" id="classes_id"
                        class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                        <option value="">Pilih Kelas</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="teacher_id" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 a 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Guru Pengajar <span class="text-gray-400 text-xs">(Opsional)</span>
                        </div>
                    </x-input-label>
                    <select name="teacher_id" id="teacher_id"
                        class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                        <option value="">Pilih Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="terms_id" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 a 2 0 002-2V7a2 2 0 00-2-2H5 a 2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </div>
                    </x-input-label>
                    <select name="terms_id" id="terms_id" required
                        class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}" {{ $term->is_active ? 'selected' : '' }}>
                                {{ $term->tahun_ajaran }} - {{ ucfirst($term->kind) }}
                                {{ $term->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Event type optional -->
                <div>
                    <x-input-label for="event_type" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 4h6m-6 4h4"></path>
                            </svg>
                            Tipe Event <span class="text-gray-400 text-xs">(Opsional)</span>
                        </div>
                    </x-input-label>
                    <input type="text" name="event_type" id="event_type"
                        class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500 transition-colors">
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-right">
                <button type="button" class="px-4 py-2 mr-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300" onclick="closeModal('historyModal')">Batal</button>
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                    <span id="modalSubmit">Simpan</span>
                </button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($events),
                    selectable: true,
                    select: function(info) {
                        openModal('create');
                        document.getElementById('start_datetime').value = info.startStr.replace('Z', '');
                        document.getElementById('end_datetime').value = info.endStr ? info.endStr.replace('Z', '') : info.startStr.replace('Z', '');
                    },
                    eventClick: function(info) {
                        const all = window.CALENDAR_EVENTS || [];
                        const data = all.find(e => e.id == info.event.id);
                        if (data) {
                            openModal('edit', data);
                        }
                    }
                });
                window.CALENDAR_EVENTS = @json($events);
                calendar.render();
            });

            function toInputDateTime(value) {
                if (!value) return '';
                value = value.replace(' ', 'T');
                return value.substring(0, 16);
            }

            function openModal(mode, data = null) {
                const form = document.getElementById('historyForm');
                const title = document.getElementById('modalTitle');
                const methodInput = document.getElementById('formMethod');

                form.reset();
                document.querySelector('[name="room_id"]').value = "{{ $room->id }}";

                if (mode === 'create') {
                    form.action = "{{ route('staff.rooms.history.store') }}";
                    methodInput.value = 'POST';
                    title.innerText = 'Tambah Alokasi Ruangan';
                } else {
                    form.action = `/staff/room-history/${data.id}`;
                    methodInput.value = 'PUT';
                    title.innerText = 'Edit Alokasi Ruangan';

                    document.getElementById('start_datetime').value = toInputDateTime(data.start);
                    document.getElementById('end_datetime').value = toInputDateTime(data.end);
                    document.getElementById('classes_id').value = data.classes_id || '';
                    document.getElementById('teacher_id').value = data.teacher_id || '';
                    document.getElementById('terms_id').value = data.terms_id || '';
                    document.getElementById('event_type').value = data.event_type || '';
                }

                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'historyModal'
                }));
            }

            function disableElement(id, state) {
                const el = document.getElementById(id);
                if (!el) return;
                el.disabled = state;
            }
        </script>
    @endpush
</x-app-layout>