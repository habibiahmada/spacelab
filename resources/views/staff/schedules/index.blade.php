<x-app-layout>
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
        viewMode: 'grid',
        majors: {{ $majors->map(fn($m) => ['id' => $m->id, 'name' => $m->name, 'logo' => $m->logo, 'count' => $m->classes_count])->toJson() }},
        loadedMajors: {},
        loadingMajor: null,
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
        }
    }">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sticky Top Bar -->
            <div
                class="bg-white dark:bg-slate-800 rounded-lg shadow-sm mb-6 sticky top-0 z-[5] border border-gray-200 dark:border-slate-700">
                <!-- Search & View Toggle -->
                <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                        <div class="flex-1 max-w-md w-full">
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Cari kelas..."
                                    class="w-full text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-200 focus:border-gray-500 focus:ring-gray-500 rounded-lg shadow-sm pl-10 pr-4 py-2.5">
                                <x-heroicon-o-magnifying-glass
                                    class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                            </div>
                        </div>

                        <div class="flex items-center gap-2 bg-gray-100 dark:bg-slate-700 rounded-lg p-1">
                            <button @click="viewMode = 'grid'"
                                :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-600 shadow-sm' : ''"
                                class="p-2 rounded-md transition-colors text-gray-700 dark:text-gray-300">
                                <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                            </button>
                            <button @click="viewMode = 'list'"
                                :class="viewMode === 'list' ? 'bg-white dark:bg-slate-600 shadow-sm' : ''"
                                class="p-2 rounded-md transition-colors text-gray-700 dark:text-gray-300">
                                <x-heroicon-o-bars-3 class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Major Tabs -->
                <div
                    class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-slate-600 scrollbar-track-transparent">
                    <div class="flex gap-2 px-4 py-3 min-w-max">
                        @foreach ($majors as $major)
                            <button @click="activeTab = '{{ $major->id }}'"
                                :class="activeTab === '{{ $major->id }}'
                                    ?
                                    'bg-gray-700 dark:bg-slate-600 text-white shadow-sm' :
                                    'bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600'"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                                @if ($major->logo)
                                    <img src="{{ $major->logo }}" alt="{{ $major->name }}"
                                        class="w-6 h-6 rounded-full object-cover flex-shrink-0 ring-2 ring-white/50">
                                @endif
                                <span>{{ $major->name }}</span>
                                <span class="text-xs opacity-75 bg-white/30 px-2 py-0.5 rounded-full"
                                    x-text="majors.find(m => m.id === '{{ $major->id }}')?.count || 0"></span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            @foreach ($majors as $major)
                <div x-show="activeTab === '{{ $major->id }}'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <!-- Loading State -->
                    <div x-show="loadingMajor === '{{ $major->id }}'"
                        class="flex items-center justify-center py-20">
                        <div class="text-center">
                            <x-heroicon-o-arrow-path
                                class="animate-spin h-12 w-12 text-gray-600 dark:text-gray-400 mx-auto mb-4" />
                            <p class="text-gray-600 dark:text-gray-400">Memuat jadwal...</p>
                        </div>
                    </div>

                    <!-- Grid View -->
                    <div x-show="viewMode === 'grid' && loadedMajors['{{ $major->id }}'] && loadingMajor !== '{{ $major->id }}'"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
                        <template x-for="classItem in loadedMajors['{{ $major->id }}'] || []"
                            :key="classItem.id">
                            <div x-show="filteredSearch === '' || classItem.full_name.toLowerCase().includes(filteredSearch.toLowerCase())"
                                x-transition
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 flex flex-col h-[520px]">

                                <!-- Card Header -->
                                <div
                                    class="px-4 py-3 bg-gradient-to-r from-gray-700 to-gray-800 dark:from-slate-800 dark:to-slate-900">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-bold text-white line-clamp-1 flex-1"
                                            x-text="classItem.full_name"></h4>
                                        <span x-show="classItem.timetable_templates && classItem.timetable_templates[0]"
                                            class="text-[10px] font-semibold text-white/90 bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full ml-2 flex-shrink-0"
                                            x-text="classItem.timetable_templates?.[0]?.version || ''"></span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div
                                    class="flex-grow overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-slate-600 scrollbar-track-transparent">
                                    <div x-show="!classItem.schedule_days || Object.keys(classItem.schedule_days).length === 0"
                                        class="flex flex-col items-center justify-center h-full text-gray-400 p-6">
                                        <x-heroicon-o-calendar class="w-16 h-16 mb-3 opacity-30" />
                                        <p class="text-sm italic">Belum ada jadwal</p>
                                    </div>
                                    <div
                                        x-show="classItem.schedule_days && Object.keys(classItem.schedule_days).length > 0">
                                        <div class="divide-y divide-gray-100 dark:divide-slate-700/50">
                                            <template x-for="(dayItems, dayNum) in classItem.schedule_days"
                                                :key="dayNum">
                                                <div class="p-4">
                                                    <!-- Day Header -->
                                                    <div
                                                        class="sticky top-0 z-10 bg-white dark:bg-slate-800 -mx-4 px-4 py-2 mb-3 border-b border-gray-200 dark:border-slate-700">
                                                        <h5
                                                            class="text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider flex items-center gap-2">
                                                            <span
                                                                class="w-2 h-2 bg-gray-500 dark:bg-gray-400 rounded-full"></span>
                                                            <span
                                                                x-text="['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][dayNum] || 'Hari ' + dayNum"></span>
                                                        </h5>
                                                    </div>

                                                    <!-- Timeline Items -->
                                                    <div
                                                        class="space-y-3 relative pl-6 before:absolute before:left-2 before:top-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-gray-300 before:via-gray-200 before:to-transparent dark:before:from-slate-700 dark:before:via-slate-800">
                                                        <template x-for="(item, itemIdx) in dayItems"
                                                            :key="itemIdx">
                                                            <div class="relative">
                                                                <!-- Timeline Dot -->
                                                                <div
                                                                    class="absolute -left-[1.15rem] top-2 w-3 h-3 bg-gray-500 dark:bg-gray-400 rounded-full border-2 border-white dark:border-slate-800 shadow-sm z-0">
                                                                </div>

                                                                <div x-show="item.is_break">
                                                                    <!-- Break Item -->
                                                                    <div
                                                                        class="bg-gray-50 dark:bg-slate-900/40 px-3 py-2 rounded-lg border-l-4 border-gray-400 dark:border-slate-600">
                                                                        <div class="flex items-center justify-between">
                                                                            <div class="flex items-center gap-2">
                                                                                <x-heroicon-o-clock
                                                                                    class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                                                                                <span
                                                                                    class="text-xs font-bold text-gray-700 dark:text-gray-200"
                                                                                    x-text="item.ordinal"></span>
                                                                            </div>
                                                                            <span
                                                                                class="text-xs font-mono text-gray-600 dark:text-gray-300 bg-white/50 dark:bg-black/20 px-2 py-0.5 rounded"
                                                                                x-text="item.start_time?.substring(0,5) + ' - ' + item.end_time?.substring(0,5)"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div x-show="!item.is_break">
                                                                    <!-- Schedule Item -->
                                                                    <div
                                                                        class="bg-white dark:bg-slate-800 p-3 rounded-lg border border-gray-200 dark:border-slate-700 shadow-sm">
                                                                        <div
                                                                            class="flex justify-between items-start gap-2 mb-2">
                                                                            <span
                                                                                class="text-xs font-bold text-gray-900 dark:text-gray-100 line-clamp-2 flex-1"
                                                                                x-text="item.teacher_subject?.subject?.name || 'Tanpa Mapel'"></span>
                                                                            <span
                                                                                class="text-[10px] font-mono text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-slate-700 px-2 py-1 rounded-md whitespace-nowrap flex-shrink-0"
                                                                                x-text="item.period?.start_time?.substring(0,5) || '-'"></span>
                                                                        </div>
                                                                        <div
                                                                            class="flex items-center justify-between gap-2 text-[10px] text-gray-600 dark:text-gray-400">
                                                                            <div
                                                                                class="flex items-center gap-1.5 flex-1 min-w-0">
                                                                                <x-heroicon-o-user
                                                                                    class="w-3.5 h-3.5 flex-shrink-0 text-gray-400" />
                                                                                <span class="truncate"
                                                                                    x-text="item.teacher_subject?.teacher?.user?.name || '-'"></span>
                                                                            </div>
                                                                            <span x-show="item.room"
                                                                                class="bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded-md font-semibold whitespace-nowrap flex items-center gap-1 flex-shrink-0">
                                                                                <x-heroicon-o-building-office
                                                                                    class="w-3 h-3" />
                                                                                <span x-text="item.room?.name"></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
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
                        </template>
                    </div>

                    <!-- List View -->
                    <div x-show="viewMode === 'list' && loadedMajors['{{ $major->id }}'] && loadingMajor !== '{{ $major->id }}'"
                        class="space-y-4">
                        <template x-for="classItem in loadedMajors['{{ $major->id }}'] || []"
                            :key="classItem.id">
                            <div x-show="filteredSearch === '' || classItem.full_name.toLowerCase().includes(filteredSearch.toLowerCase())"
                                x-transition
                                class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

                                <!-- List Header -->
                                <div
                                    class="px-5 py-4 bg-gradient-to-r from-gray-700 to-gray-800 dark:from-slate-800 dark:to-slate-900 flex justify-between items-center">
                                    <h4 class="text-base font-bold text-white" x-text="classItem.full_name"></h4>
                                    <span x-show="classItem.timetable_templates && classItem.timetable_templates[0]"
                                        class="text-xs font-semibold text-white/90 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full"
                                        x-text="classItem.timetable_templates?.[0]?.version || ''"></span>
                                </div>

                                <!-- List Body -->
                                <div class="p-5">
                                    <p x-show="!classItem.schedule_days || Object.keys(classItem.schedule_days).length === 0"
                                        class="text-sm text-gray-400 italic text-center py-4">Belum ada jadwal</p>
                                    <div x-show="classItem.schedule_days && Object.keys(classItem.schedule_days).length > 0"
                                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <template x-for="(dayItems, dayNum) in classItem.schedule_days"
                                            :key="dayNum">
                                            <div
                                                class="border border-gray-200 dark:border-slate-700 rounded-lg p-4 bg-gray-50 dark:bg-slate-900/50">
                                                <h5
                                                    class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                    <span
                                                        class="w-2 h-2 bg-gray-500 dark:bg-gray-400 rounded-full"></span>
                                                    <span
                                                        x-text="['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][dayNum] || 'Hari ' + dayNum"></span>
                                                </h5>
                                                <div class="space-y-2">
                                                    <template x-for="(item, itemIdx) in dayItems"
                                                        :key="itemIdx">
                                                        <div>
                                                            <div x-show="item.is_break"
                                                                class="bg-gray-100 dark:bg-slate-800 px-2 py-1.5 rounded text-xs text-gray-700 dark:text-gray-200 font-semibold">
                                                                <span
                                                                    x-text="'ISTIRAHAT (' + item.start_time?.substring(0,5) + ')'"></span>
                                                            </div>
                                                            <div x-show="!item.is_break"
                                                                class="bg-white dark:bg-slate-800 p-2 rounded border border-gray-200 dark:border-slate-700 text-xs">
                                                                <div class="font-semibold text-gray-900 dark:text-gray-100 mb-1"
                                                                    x-text="item.teacher_subject?.subject?.name || 'Tanpa Mapel'">
                                                                </div>
                                                                <div
                                                                    class="text-gray-600 dark:text-gray-400 flex justify-between">
                                                                    <span
                                                                        x-text="item.teacher_subject?.teacher?.user?.name || '-'"></span>
                                                                    <span
                                                                        class="text-gray-700 dark:text-gray-200 font-mono"
                                                                        x-text="item.period?.start_time?.substring(0,5) || '-'"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
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
