<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mata Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Mata Pelajaran</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola kurikulum dan alokasi pengajar
                        </p>
                    </div>
                    <button onclick="openSubjectModal()"
                        class="inline-flex items-center px-4 py-2.5 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Mata Pelajaran
                    </button>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div
                    class="mb-6 bg-gray-50 dark:bg-gray-800 border-l-4 border-gray-900 dark:border-gray-100 rounded-r-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-900 dark:text-gray-100 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-600 dark:border-red-400 rounded-r-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <ul class="text-sm text-red-700 dark:text-red-300 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="mb-6">
                <form method="GET" action="{{ route('staff.subjects.index') }}">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan kode atau nama mata pelajaran..."
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:border-transparent transition-all duration-200">
                    </div>
                </form>
            </div>

            <!-- Subjects Grid -->
            <div class="grid grid-cols-1 gap-4">
                @forelse ($subjects as $subject)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <!-- Subject Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $subject->code }}
                                        </span>
                                        @if ($subject->type)
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $subject->type }}</span>
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">
                                        {{ $subject->name }}
                                    </h4>
                                    @if ($subject->description)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                            {{ $subject->description }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Stats & Actions -->
                                <div class="flex items-center gap-4">
                                    <!-- Stats -->
                                    <div
                                        class="flex items-center gap-4 pr-4 border-r border-gray-200 dark:border-gray-700">
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $subject->majors->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Jurusan</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $subject->teachers->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Guru</div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2">
                                        <button onclick='openMajorsModal(@json($subject))'
                                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                                            title="Kelola Jurusan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </button>
                                        <button onclick='openTeachersModal(@json($subject))'
                                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                                            title="Kelola Guru">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                        <button onclick='openSubjectModal(@json($subject))'
                                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button onclick="deleteSubject('{{ $subject->id }}')"
                                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Belum ada data mata pelajaran</p>
                        <button onclick="openSubjectModal()"
                            class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah mata pelajaran pertama
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($subjects->hasPages())
                <div class="mt-6">
                    {{ $subjects->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Subject Modal -->
    <x-modal name="subjectModal" :show="false" focusable>
        <form id="subjectForm" method="POST" action="{{ route('staff.subjects.store') }}" class="p-6">
            @csrf
            <input type="hidden" name="_method" id="subjectMethod" value="POST">

            <h2 id="subjectModalTitle" class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                Tambah Mata Pelajaran
            </h2>

            <div class="space-y-5">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Kode Mata Pelajaran
                    </label>
                    <input id="code" name="code" type="text" required
                        class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:border-transparent transition-all duration-200" />
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Nama Mata Pelajaran
                    </label>
                    <input id="name" name="name" type="text" required
                        class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:border-transparent transition-all duration-200" />
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tipe
                    </label>
                    <div class="relative">
                        <select id="type" name="type" required
                            class="block w-full appearance-none px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:border-transparent transition-all duration-200">
                            <option value="teori">Teori</option>
                            <option value="praktikum">Praktikum</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Deskripsi <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 focus:border-transparent transition-all duration-200"></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-medium text-white dark:text-gray-900 bg-gray-900 dark:bg-gray-100 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Manage Majors Modal -->
    <x-modal name="majorsModal" :show="false" focusable>
        <form id="majorsForm" method="POST" action="#" class="p-6">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                Kelola Jurusan
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                <span id="majorsModalSubjectName" class="font-medium text-gray-700 dark:text-gray-300"></span>
            </p>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Pilih jurusan yang mempelajari mata pelajaran ini
                </p>
                <div
                    class="max-h-80 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3 bg-gray-50 dark:bg-gray-900/50">
                    @foreach ($majors as $major)
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-white dark:hover:bg-gray-800 cursor-pointer transition-colors duration-200">
                            <input id="major_chk_{{ $major->id }}" name="majors[]" value="{{ $major->id }}"
                                type="checkbox"
                                class="w-4 h-4 text-gray-900 dark:text-gray-100 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $major->name }} <span class="text-gray-400">({{ $major->code }})</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-medium text-white dark:text-gray-900 bg-gray-900 dark:bg-gray-100 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Manage Teachers Modal -->
    <x-modal name="teachersModal" :show="false" focusable>
        <form id="teachersForm" method="POST" action="#" class="p-6">
            @csrf
            @method('PUT')

            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                Kelola Guru
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                <span id="teachersModalSubjectName" class="font-medium text-gray-700 dark:text-gray-300"></span>
            </p>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    Pilih guru yang mengampu mata pelajaran ini
                </p>
                <div
                    class="max-h-80 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3 bg-gray-50 dark:bg-gray-900/50">
                    @foreach ($teachers as $teacher)
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-white dark:hover:bg-gray-800 cursor-pointer transition-colors duration-200">
                            <input id="teacher_chk_{{ $teacher->id }}" name="teachers[]"
                                value="{{ $teacher->id }}" type="checkbox"
                                class="w-4 h-4 text-gray-900 dark:text-gray-100 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-gray-900 dark:focus:ring-gray-100 dark:bg-gray-700 dark:border-gray-600">
                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ $teacher->user->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-medium text-white dark:text-gray-900 bg-gray-900 dark:bg-gray-100 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Form -->
    <form id="deleteSubjectForm" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function openSubjectModal(subject = null) {
            const modalTitle = document.getElementById('subjectModalTitle');
            const form = document.getElementById('subjectForm');
            const methodInput = document.getElementById('subjectMethod');
            const codeInput = document.getElementById('code');
            const nameInput = document.getElementById('name');
            const typeInput = document.getElementById('type');
            const descInput = document.getElementById('description');

            if (subject) {
                modalTitle.innerText = 'Edit Mata Pelajaran';
                form.action = `/staff/subjects/${subject.id}`;
                methodInput.value = 'PUT';
                codeInput.value = subject.code;
                nameInput.value = subject.name;
                typeInput.value = subject.type || '';
                descInput.value = subject.description || '';
            } else {
                modalTitle.innerText = 'Tambah Mata Pelajaran';
                form.action = "{{ route('staff.subjects.store') }}";
                methodInput.value = 'POST';
                codeInput.value = '';
                nameInput.value = '';
                typeInput.value = '';
                descInput.value = '';
            }

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'subjectModal'
            }));
        }

        function openMajorsModal(subject) {
            document.getElementById('majorsModalSubjectName').innerText = subject.name;
            const form = document.getElementById('majorsForm');
            form.action = `/staff/subjects/${subject.id}/majors`;

            document.querySelectorAll('input[name="majors[]"]').forEach(el => el.checked = false);

            if (subject.majors) {
                subject.majors.forEach(major => {
                    const checkbox = document.getElementById(`major_chk_${major.id}`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'majorsModal'
            }));
        }

        function openTeachersModal(subject) {
            document.getElementById('teachersModalSubjectName').innerText = subject.name;
            const form = document.getElementById('teachersForm');
            form.action = `/staff/subjects/${subject.id}/teachers`;

            document.querySelectorAll('input[name="teachers[]"]').forEach(el => el.checked = false);

            if (subject.teachers) {
                subject.teachers.forEach(teacher => {
                    const checkbox = document.getElementById(`teacher_chk_${teacher.id}`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'teachersModal'
            }));
        }

        function deleteSubject(id) {
            if (confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.getElementById('deleteSubjectForm');
                form.action = `/staff/subjects/${id}`;
                form.submit();
            }
        }
    </script>
</x-app-layout>
