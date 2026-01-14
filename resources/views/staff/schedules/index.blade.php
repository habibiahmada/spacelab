<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Jadwal Pelajaran') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6" x-data="{
        activeTab: '{{ $majors->first()->id ?? '' }}',
        search: '',
        searchDebounce: null,
        filteredSearch: '',
        viewMode: 'table',
        expandedClass: null,
        majors: {{ $majors->map(fn($m) => ['id' => $m->id, 'name' => $m->name, 'logo' => $m->logo, 'count' => $m->classes_count])->toJson() }},
        loadedMajors: {},
        loadingMajor: null,
        dayNames: ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        dayColors: {
            1: { bg: 'bg-blue-50 dark:bg-blue-900/20', border: 'border-blue-300 dark:border-blue-700', text: 'text-blue-700 dark:text-blue-300', badge: 'bg-blue-500' },
            2: { bg: 'bg-emerald-50 dark:bg-emerald-900/20', border: 'border-emerald-300 dark:border-emerald-700', text: 'text-emerald-700 dark:text-emerald-300', badge: 'bg-emerald-500' },
            3: { bg: 'bg-amber-50 dark:bg-amber-900/20', border: 'border-amber-300 dark:border-amber-700', text: 'text-amber-700 dark:text-amber-300', badge: 'bg-amber-500' },
            4: { bg: 'bg-purple-50 dark:bg-purple-900/20', border: 'border-purple-300 dark:border-purple-700', text: 'text-purple-700 dark:text-purple-300', badge: 'bg-purple-500' },
            5: { bg: 'bg-rose-50 dark:bg-rose-900/20', border: 'border-rose-300 dark:border-rose-700', text: 'text-rose-700 dark:text-rose-300', badge: 'bg-rose-500' },
            6: { bg: 'bg-cyan-50 dark:bg-cyan-900/20', border: 'border-cyan-300 dark:border-cyan-700', text: 'text-cyan-700 dark:text-cyan-300', badge: 'bg-cyan-500' }
        },
        async loadMajorSchedules(majorId) {
            if (this.loadedMajors[majorId]) return;
            this.loadingMajor = majorId;
            try {
                const response = await fetch(`/staff/schedules/major/${majorId}`);
                const data = await response.json();
                if (data.success) {
                    this.loadedMajors[majorId] = data.classes;
                }
            } catch (error) {
                console.error('Error loading schedules:', error);
            } finally {
                this.loadingMajor = null;
            }
        },
        init() {
            this.$watch('activeTab', (newTab) => {
                if (newTab) this.loadMajorSchedules(newTab);
            });
            this.$watch('search', (value) => {
                clearTimeout(this.searchDebounce);
                this.searchDebounce = setTimeout(() => {
                    this.filteredSearch = value;
                }, 300);
            });
            if (this.activeTab) this.loadMajorSchedules(this.activeTab);
        },
        getScheduleCount(classItem) {
            if (!classItem.schedule_days) return 0;
            return Object.values(classItem.schedule_days).flat().filter(i => !i.is_break).length;
        }
    }">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sticky Top Bar -->
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm mb-6 sticky top-0 z-[5] border border-gray-200/80 dark:border-slate-700/80">
                <!-- Search & View Toggle -->
                <div class="p-4 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
                        <div class="flex-1 max-w-sm w-full">
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Cari kelas..."
                                    class="w-full text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-900/50 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 rounded-xl pl-10 pr-4 py-2.5 transition-all">
                                <x-heroicon-o-magnifying-glass
                                    class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" />
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 bg-gray-100 dark:bg-slate-700/50 rounded-xl p-1">
                            <button @click="viewMode = 'table'"
                                :class="viewMode === 'table' ? 'bg-white dark:bg-slate-600 shadow-sm' :
                                    'hover:bg-white/50 dark:hover:bg-slate-600/50'"
                                class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 transition-all flex items-center gap-1.5">
                                <x-heroicon-o-table-cells class="w-4 h-4" />
                                <span>Tabel</span>
                            </button>
                            <button @click="viewMode = 'compact'"
                                :class="viewMode === 'compact' ? 'bg-white dark:bg-slate-600 shadow-sm' :
                                    'hover:bg-white/50 dark:hover:bg-slate-600/50'"
                                class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 transition-all flex items-center gap-1.5">
                                <x-heroicon-o-squares-2x2 class="w-4 h-4" />
                                <span>Kartu</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Major Tabs -->
                <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-slate-600">
                    <div class="flex gap-1 px-4 py-3 min-w-max">
                        @foreach ($majors as $major)
                            <button @click="activeTab = '{{ $major->id }}'"
                                :class="activeTab === '{{ $major->id }}'
                                    ?
                                    'bg-blue-600 dark:bg-blue-500 text-white' :
                                    'bg-gray-50 dark:bg-slate-700/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700'"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-xl transition-all whitespace-nowrap">
                                @if ($major->logo)
                                    <img src="{{ $major->logo }}" alt="{{ $major->name }}"
                                        class="w-5 h-5 rounded object-cover flex-shrink-0">
                                @endif
                                <span>{{ $major->name }}</span>
                                <span class="text-xs font-semibold px-1.5 py-0.5 rounded-md"
                                    :class="activeTab === '{{ $major->id }}' ? 'bg-white/20' :
                                        'bg-gray-200 dark:bg-slate-600'"
                                    x-text="majors.find(m => m.id === '{{ $major->id }}')?.count || 0"></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            @foreach ($majors as $major)
                <div x-show="activeTab === '{{ $major->id }}'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                    <!-- Loading State -->
                    <div x-show="loadingMajor === '{{ $major->id }}'"
                        class="flex items-center justify-center py-20">
                        <div class="text-center">
                            <x-heroicon-o-arrow-path class="animate-spin h-10 w-10 text-blue-500 mx-auto mb-3" />
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Memuat jadwal...</p>
                        </div>
                    </div>

                    <!-- Table View -->
                    <div
                        x-show="viewMode === 'table' && loadedMajors['{{ $major->id }}'] && loadingMajor !== '{{ $major->id }}'">
                        <div class="space-y-3">
                            <template x-for="classItem in loadedMajors['{{ $major->id }}'] || []"
                                :key="classItem.id">
                                <div x-show="filteredSearch === '' || classItem.full_name.toLowerCase().includes(filteredSearch.toLowerCase())"
                                    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

                                    <!-- Class Header - Clickable -->
                                    <button
                                        @click="expandedClass = expandedClass === classItem.id ? null : classItem.id"
                                        class="w-full px-5 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                <span
                                                    x-text="classItem.full_name?.split(' ')[0]?.substring(0, 2) || 'K'"></span>
                                            </div>
                                            <div class="text-left">
                                                <h3 class="font-semibold text-gray-900 dark:text-gray-100"
                                                    x-text="classItem.full_name"></h3>
                                                <div class="flex items-center gap-3 mt-0.5">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400"
                                                        x-text="getScheduleCount(classItem) + ' pelajaran'"></span>
                                                    <span x-show="classItem.timetable_templates?.[0]"
                                                        class="text-xs text-blue-600 dark:text-blue-400 font-medium"
                                                        x-text="classItem.timetable_templates?.[0]?.version"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <!-- Quick Day Pills -->
                                            <div class="hidden sm:flex items-center gap-1">
                                                <template x-for="dayNum in [1,2,3,4,5,6]" :key="dayNum">
                                                    <span x-show="classItem.schedule_days?.[dayNum]?.length > 0"
                                                        class="w-2 h-2 rounded-full"
                                                        :class="dayColors[dayNum]?.badge"></span>
                                                </template>
                                            </div>
                                            <x-heroicon-o-chevron-down
                                                class="w-5 h-5 text-gray-400 transition-transform duration-200"
                                                ::class="expandedClass === classItem.id ? 'rotate-180' : ''" />
                                        </div>
                                    </button>

                                    <!-- Expanded Schedule Table -->
                                    <div x-show="expandedClass === classItem.id" x-collapse x-cloak>
                                        <div class="border-t border-gray-100 dark:border-slate-700/50">
                                            <!-- No Schedule -->
                                            <div x-show="!classItem.schedule_days || Object.keys(classItem.schedule_days).length === 0"
                                                class="px-5 py-8 text-center">
                                                <x-heroicon-o-calendar
                                                    class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-2" />
                                                <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada jadwal
                                                    untuk kelas ini</p>
                                            </div>

                                            <!-- Schedule Grid by Day -->
                                            <div x-show="classItem.schedule_days && Object.keys(classItem.schedule_days).length > 0"
                                                class="p-4">
                                                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-3">
                                                    <template x-for="dayNum in [1,2,3,4,5,6]" :key="dayNum">
                                                        <div x-show="classItem.schedule_days?.[dayNum]?.length > 0"
                                                            class="rounded-xl border p-4"
                                                            :class="dayColors[dayNum]?.bg + ' ' + dayColors[dayNum]?.border">

                                                            <!-- Day Header -->
                                                            <div class="flex items-center gap-2 mb-3 pb-2 border-b"
                                                                :class="dayColors[dayNum]?.border">
                                                                <span class="w-2 h-2 rounded-full"
                                                                    :class="dayColors[dayNum]?.badge"></span>
                                                                <span class="font-semibold text-sm"
                                                                    :class="dayColors[dayNum]?.text"
                                                                    x-text="dayNames[dayNum]"></span>
                                                                <span
                                                                    class="text-xs text-gray-500 dark:text-gray-400 ml-auto"
                                                                    x-text="classItem.schedule_days?.[dayNum]?.filter(i => !i.is_break).length + ' mapel'"></span>
                                                            </div>

                                                            <!-- Schedule Items -->
                                                            <div class="space-y-2">
                                                                <template
                                                                    x-for="(item, idx) in classItem.schedule_days?.[dayNum] || []"
                                                                    :key="idx">
                                                                    <div>
                                                                        <!-- Break -->
                                                                        <div x-show="item.is_break"
                                                                            class="flex items-center justify-center gap-2 py-1.5 px-3 bg-amber-100/50 dark:bg-amber-900/30 rounded-lg text-xs text-amber-700 dark:text-amber-300">
                                                                            <x-heroicon-o-pause class="w-3 h-3" />
                                                                            <span class="font-medium"
                                                                                x-text="item.start_time?.substring(0,5)"></span>
                                                                            <span>Istirahat</span>
                                                                        </div>

                                                                        <!-- Subject -->
                                                                        <div x-show="!item.is_break"
                                                                            class="flex items-start gap-3 py-2 px-3 bg-white/70 dark:bg-slate-800/70 rounded-lg">
                                                                            <span
                                                                                class="text-xs font-mono font-semibold text-gray-500 dark:text-gray-400 min-w-[40px]"
                                                                                x-text="item.period?.start_time?.substring(0,5)"></span>
                                                                            <div class="flex-1 min-w-0">
                                                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"
                                                                                    x-text="item.teacher_subject?.subject?.name || 'Tanpa Mapel'">
                                                                                </p>
                                                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate"
                                                                                    x-text="item.teacher_subject?.teacher?.user?.name || '-'">
                                                                                </p>
                                                                            </div>
                                                                            <span x-show="item.room_history?.room"
                                                                                class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded flex-shrink-0"
                                                                                x-text="item.room_history?.room?.name"></span>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!loadedMajors['{{ $major->id }}']?.length" class="text-center py-16">
                            <x-heroicon-o-academic-cap
                                class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" />
                            <p class="text-gray-500 dark:text-gray-400">Belum ada kelas pada jurusan ini</p>
                        </div>
                    </div>

                    <!-- Compact Card View -->
                    <div x-show="viewMode === 'compact' && loadedMajors['{{ $major->id }}'] && loadingMajor !== '{{ $major->id }}'"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
                        <template x-for="classItem in loadedMajors['{{ $major->id }}'] || []"
                            :key="classItem.id">
                            <div x-show="filteredSearch === '' || classItem.full_name.toLowerCase().includes(filteredSearch.toLowerCase())"
                                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">

                                <!-- Card Header -->
                                <div
                                    class="px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-500 dark:to-indigo-500">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-white text-sm truncate"
                                            x-text="classItem.full_name"></h4>
                                        <span x-show="classItem.timetable_templates?.[0]"
                                            class="text-xs text-white/80 bg-white/20 px-2 py-0.5 rounded"
                                            x-text="classItem.timetable_templates?.[0]?.version"></span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 max-h-[400px] overflow-y-auto scrollbar-thin">
                                    <!-- No Schedule -->
                                    <div x-show="!classItem.schedule_days || Object.keys(classItem.schedule_days).length === 0"
                                        class="text-center py-6">
                                        <x-heroicon-o-calendar
                                            class="w-10 h-10 text-gray-200 dark:text-gray-700 mx-auto mb-2" />
                                        <p class="text-xs text-gray-400">Belum ada jadwal</p>
                                    </div>

                                    <!-- Schedule by Day -->
                                    <div x-show="classItem.schedule_days && Object.keys(classItem.schedule_days).length > 0"
                                        class="space-y-3">
                                        <template x-for="dayNum in [1,2,3,4,5,6]" :key="dayNum">
                                            <div x-show="classItem.schedule_days?.[dayNum]?.length > 0">
                                                <!-- Day Label -->
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="w-1.5 h-1.5 rounded-full"
                                                        :class="dayColors[dayNum]?.badge"></span>
                                                    <span class="text-xs font-semibold"
                                                        :class="dayColors[dayNum]?.text"
                                                        x-text="dayNames[dayNum]"></span>
                                                </div>

                                                <!-- Items -->
                                                <div class="space-y-1.5 pl-3.5 border-l-2"
                                                    :class="dayColors[dayNum]?.border">
                                                    <template
                                                        x-for="(item, idx) in classItem.schedule_days?.[dayNum]?.filter(i => !i.is_break).slice(0, 4) || []"
                                                        :key="idx">
                                                        <div class="flex items-center gap-2 text-xs">
                                                            <span class="text-gray-400 font-mono min-w-[35px]"
                                                                x-text="item.period?.start_time?.substring(0,5)"></span>
                                                            <span class="text-gray-700 dark:text-gray-300 truncate"
                                                                x-text="item.teacher_subject?.subject?.name || '-'"></span>
                                                        </div>
                                                    </template>
                                                    <template
                                                        x-if="classItem.schedule_days?.[dayNum]?.filter(i => !i.is_break).length > 4">
                                                        <p class="text-xs text-gray-400"
                                                            x-text="'+' + (classItem.schedule_days?.[dayNum]?.filter(i => !i.is_break).length - 4) + ' lainnya'">
                                                        </p>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div
                                    class="px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
                                    <span class="text-xs text-gray-500 dark:text-gray-400"
                                        x-text="getScheduleCount(classItem) + ' pelajaran'"></span>
                                    <div class="flex gap-0.5">
                                        <template x-for="dayNum in [1,2,3,4,5,6]" :key="dayNum">
                                            <span class="w-1.5 h-1.5 rounded-full"
                                                :class="classItem.schedule_days?.[dayNum]?.length > 0 ? dayColors[dayNum]
                                                    ?.badge : 'bg-gray-200 dark:bg-gray-600'"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
