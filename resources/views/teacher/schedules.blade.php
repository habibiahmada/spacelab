<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            Jadwal Mengajar
        </h2>
    </x-slot>

    @php
        $currentTime = $currentTime ?? \Carbon\Carbon::now();
        $currentDayIndex = $currentDayIndex ?? (int) $currentTime->format('N');
        $dayNames = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];
    @endphp

    <div class="space-y-6 lg:space-y-0 lg:flex lg:items-start lg:gap-6">
        <main class="lg:flex-1">
            @foreach($allSchedules as $day => $schedules)

            <div class="mt-4 mb-2 flex items-center gap-2 scroll-mt-28" id="day-{{ $day }}">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                <h3 class="text-base md:text-xl font-semibold tracking-wide px-3 py-1 bg-gray-800 rounded-full text-white shadow-sm">
                    {{ $dayNames[$day] ?? 'Hari' }}
                </h3>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
            </div>

            @php
                // Process schedules to separate period-only entries from actual classes
                $processedSchedules = [];
                $values = $schedules->values();

                foreach ($values as $item) {
                    // Check if this is a period-only entry (break time)
                    $isPeriodOnly = isset($item->is_period_only) && $item->is_period_only;

                    if ($isPeriodOnly) {
                        // Add period-only entry as-is
                        $processedSchedules[] = (object) [
                            'type' => 'period',
                            'period' => $item->period,
                            'start_time' => $item->period?->start_time,
                            'end_time' => $item->period?->end_time,
                            'day_of_week' => $item->day_of_week,
                            'item' => $item,
                        ];
                    } else {
                        // Add timetable entry
                        $processedSchedules[] = (object) [
                            'type' => 'class',
                            'period' => $item->period,
                            'start_time' => $item->period?->start_time ?? $item->period?->start_date?->format('H:i:s'),
                            'end_time' => $item->period?->end_time ?? $item->period?->end_date?->format('H:i:s'),
                            'subject' => $item->teacherSubject?->subject ?? null,
                            'template' => $item->template ?? null,
                            'roomHistory' => $item->roomHistory ?? null,
                            'day_of_week' => $item->day_of_week,
                            'item' => $item,
                        ];
                    }
                }
            @endphp

            @if(collect($processedSchedules)->isEmpty())
                <div class="p-3 mb-3 border rounded-lg bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-center">
                    <div class="mx-auto mb-3 text-gray-400 dark:text-gray-600 inline-block">
                        <x-heroicon-o-book-open class="w-8 h-8 text-gray-400 dark:text-gray-600" />
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Tidak ada jadwal untuk hari ini.</p>
                </div>
            @else
                {{-- Card Grid Layout --}}
                <div class="grid gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 items-stretch mb-4">
                    @foreach($processedSchedules as $schedule)
                        @php
                            $startTimeStr = $schedule->start_time;
                            $endTimeStr = $schedule->end_time;

                            // Convert to Carbon for comparison
                            try {
                                $startCarbon = $startTimeStr ? \Carbon\Carbon::parse($startTimeStr) : null;
                            } catch (\Exception $e) {
                                $startCarbon = null;
                            }
                            try {
                                $endCarbon = $endTimeStr ? \Carbon\Carbon::parse($endTimeStr) : null;
                            } catch (\Exception $e) {
                                $endCarbon = null;
                            }

                            $isOngoing = ((int) $schedule->day_of_week === (int) $currentDayIndex) && $startCarbon && $endCarbon ? ($currentTime->between($startCarbon, $endCarbon)) : false;
                            $isPast = ((int) $schedule->day_of_week === (int) $currentDayIndex) && $endCarbon ? ($endCarbon->lt($currentTime)) : false;
                        @endphp

                        @if($schedule->type === 'period')
                            {{-- PERIOD CARD (Break Time) --}}
                            <div class="group relative text-sm">
                                <div class="
                                    relative rounded-lg overflow-hidden transition-all duration-150 h-full
                                    {{ $isOngoing
                                        ? 'bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 shadow-lg'
                                        : ($isPast
                                            ? 'bg-gray-50 dark:bg-gray-800/30 border border-gray-200 dark:border-gray-700 opacity-50'
                                            : 'bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-800/50 dark:to-gray-800/30 border border-slate-200 dark:border-gray-700')
                                    }}
                                ">
                                    {{-- Top Accent Bar --}}
                                    <div class="h-1 {{ $isOngoing ? 'bg-amber-400 dark:bg-amber-600 animate-pulse' : 'bg-slate-300 dark:bg-slate-600' }}"></div>

                                    {{-- Status Badge --}}
                                    @if ($isOngoing)
                                        <div class="absolute top-3 right-3 z-10">
                                            <div class="bg-amber-500 text-white px-2.5 py-1 rounded-full shadow text-[10px] font-semibold">
                                                BERLANGSUNG
                                            </div>
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        {{-- Break Icon & Label --}}
                                        <div class="flex items-center justify-center mb-3">
                                            <div class="bg-slate-200 dark:bg-slate-700 p-3 rounded-full">
                                                <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <h4 class="text-center text-base font-semibold text-slate-700 dark:text-slate-300 mb-3">
                                            {{ $schedule->period?->name ?? 'Istirahat' }}
                                        </h4>

                                        {{-- Time Display --}}
                                        <div class="bg-white/50 dark:bg-gray-900/30 rounded-lg p-3 border border-slate-200 dark:border-gray-700">
                                            <div class="flex items-center justify-center gap-3 text-slate-700 dark:text-slate-300">
                                                <div class="text-center">
                                                    <div class="text-lg font-bold">
                                                        {{ $startTimeStr ? \Carbon\Carbon::parse($startTimeStr)->format('H:i') : '-' }}
                                                    </div>
                                                    <div class="text-[10px] opacity-70">Mulai</div>
                                                </div>

                                                <div class="text-slate-400 dark:text-slate-500">—</div>

                                                <div class="text-center">
                                                    <div class="text-lg font-bold">
                                                        {{ $endTimeStr ? \Carbon\Carbon::parse($endTimeStr)->format('H:i') : '-' }}
                                                    </div>
                                                    <div class="text-[10px] opacity-70">Selesai</div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($schedule->period?->ordinal)
                                            <div class="mt-3 text-center">
                                                <span class="inline-block px-3 py-1 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-full text-xs font-medium">
                                                    Jam ke {{ $schedule->period->ordinal }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- CLASS CARD (Timetable Entry) --}}
                            <div class="group relative text-sm">
                                <div class="
                                    relative rounded-lg overflow-hidden transition-all duration-150 h-full
                                    {{ $isOngoing
                                        ? 'bg-gray-50 dark:bg-gray-900 border-2 border-gray-300 dark:border-gray-700 shadow-lg shadow-gray-200/40 dark:shadow-gray-800/30 scale-105'
                                        : ($isPast
                                            ? 'bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 opacity-60'
                                            : 'bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:shadow-xl dark:hover:shadow-gray-800/50 hover:border-gray-300 dark:hover:border-gray-600')
                                    }}
                                ">
                                    {{-- Top Accent Bar --}}
                                    <div class="h-1 {{ $isOngoing ? 'bg-gray-300 dark:bg-gray-700 animate-pulse' : 'bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-700 dark:to-gray-600' }}"></div>

                                    {{-- Status Badge --}}
                                    @if ($isOngoing)
                                        <div class="absolute top-3 right-3 z-10">
                                            <div class="bg-gray-800 text-white px-3 py-1 rounded-full shadow flex items-center gap-2 animate-bounce">
                                                <span class="relative flex h-2.5 w-2.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                                                </span>
                                                <span class="text-[11px] font-semibold">BERLANGSUNG</span>
                                            </div>
                                        </div>
                                    @elseif ($isPast)
                                        <div class="absolute top-3 right-3 z-10">
                                            <div class="bg-gray-400 dark:bg-gray-700 text-white px-3 py-1 rounded-full shadow">
                                                <span class="text-[11px] font-semibold">SELESAI</span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="p-2">
                                        {{-- Time Display - Horizontal Layout --}}
                                        <div class="
                                            flex items-center justify-between mb-2 px-2 py-1 rounded-md
                                            {{ $isOngoing
                                                ? 'bg-gray-800 text-white shadow-sm'
                                                : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                                            }}
                                        ">
                                            <div class="text-center min-w-[48px]">
                                                <div class="text-sm font-semibold">
                                                    {{ $startTimeStr ? \Carbon\Carbon::parse($startTimeStr)->format('H:i') : '-' }}
                                                </div>
                                                <div class="text-[10px] opacity-75 mt-1">Mulai</div>
                                            </div>

                                            <div class="flex-1 flex items-center justify-center px-1">
                                                <x-heroicon-o-book-open class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                            </div>

                                            <div class="text-center min-w-[48px]">
                                                <div class="text-sm font-semibold">
                                                    {{ $endTimeStr ? \Carbon\Carbon::parse($endTimeStr)->format('H:i') : '-' }}
                                                </div>
                                                <div class="text-[10px] opacity-75 mt-1">Selesai</div>
                                            </div>
                                        </div>

                                        {{-- Subject Info --}}
                                        <div class="mb-2 pb-2 border-b border-gray-200 dark:border-gray-700">
                                            @if($schedule->period?->ordinal)
                                                <div class="mb-2">
                                                    <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-800 rounded-full text-[11px] font-semibold text-gray-700 dark:text-gray-300">
                                                        Jam ke {{ $schedule->period->ordinal }}
                                                    </span>
                                                </div>
                                            @endif
                                            <h4 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                {{ $schedule->subject?->name ?? '-' }}
                                            </h4>
                                            @if($schedule->subject?->code)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800/30 dark:text-gray-300">
                                                    {{ $schedule->subject->code }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Class Info --}}
                                        <div class="mb-2 flex items-center gap-2 p-2 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900">
                                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow">
                                                <x-heroicon-o-user-group class="w-5 h-5 text-white" />
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kelas</p>
                                                <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                                    {{ $schedule->template?->class?->full_name ?? $schedule->template?->class?->name ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Room Info --}}
                                        <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <div class="flex-shrink-0 w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center shadow">
                                                <x-heroicon-o-building-office-2 class="w-5 h-5 text-white" />
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Ruangan</p>
                                                <p class="font-medium text-gray-900 dark:text-white text-xs truncate">
                                                    {{ $schedule->roomHistory?->room?->name ?? '-' }}
                                                </p>
                                                @if($schedule->roomHistory?->room?->building?->name)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        📍 {{ $schedule->roomHistory->room->building->name }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            @endforeach
        </main>

        {{-- Desktop: Right sidebar --}}
        <aside class="hidden xl:block w-56 lg:sticky lg:top-28 lg:h-[calc(100vh-7rem)] lg:overflow-auto lg:flex-shrink-0" style="height: calc(100vh - 10rem);">
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-2 shadow-md h-full">
                @for ($d = 1; $d <= 7; $d++)
                    <a href="#day-{{ $d }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors duration-150 hover:bg-gray-100 dark:hover:bg-gray-800 {{ $d === $currentDayIndex ? 'bg-gray-100 dark:bg-gray-900/20' : '' }}">
                        <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $dayNames[$d] }}</span>
                    </a>
                @endfor

                {{-- Subjects sidebar --}}
                <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3 px-3">Pelajaran Saya</h4>
                    <div class="px-2 space-y-2">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-md">
                            <x-heroicon-o-academic-cap class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ $totalSubjects }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($subjects as $subject)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                    {{ $subject->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- Mobile: Floating menu --}}
    <div class="xl:hidden fixed bottom-4 right-4 z-50 flex items-end justify-end">
        <div class="relative">
            <button id="dayToggleBtn" aria-expanded="false" aria-controls="dayMenu" class="bg-gray-800 p-3 rounded-full shadow-lg text-white focus:outline-none">
                <x-heroicon-o-book-open class="w-5 h-5 text-white" />
            </button>
            <div id="dayMenu" class="hidden absolute right-0 bottom-14 w-44 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-md p-2">
                @for ($d = 1; $d <= 7; $d++)
                    <a href="#day-{{ $d }}" onclick="document.getElementById('dayMenu').classList.add('hidden')" class="flex items-center gap-2 px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                        <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $dayNames[$d] }}</span>
                    </a>
                @endfor
            </div>
        </div>
    </div>

    {{-- Mobile menu toggle JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('dayToggleBtn');
            var menu = document.getElementById('dayMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', !expanded);
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!menu.classList.contains('hidden') && !btn.contains(e.target)) {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>

</x-app-layout>
