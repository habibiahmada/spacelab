<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            Jadwal Pelajaran
        </h2>
    </x-slot>

    @php
        $currentTime = $currentTime ?? \Carbon\Carbon::now();
        $currentDayIndex = $currentDayIndex ?? (int) $currentTime->format('N');
        $dayNames = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];
    @endphp

    {{-- Wrap content + sidebar in a single responsive container --}}
    <div class="space-y-6 lg:space-y-0 lg:flex lg:items-start lg:gap-6">
        <main class="lg:flex-1">
            @foreach($allSchedules as $day => $schedules)
            {{-- day header --}}
            
            {{-- Day Header with Modern Style --}}
            <div class="mt-4 mb-2 flex items-center gap-2 scroll-mt-28" id="day-{{ $day }}">
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                <h3 class="text-base md:text-xl font-semibold tracking-wide px-3 py-1 bg-gray-800 rounded-full text-white shadow-sm">
                    {{ $dayNames[$day] ?? 'Hari' }}
                </h3>
                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
            </div>

            @php
                // Merge adjacent schedule items into a single card when they're consecutive
                // and share the same core properties (subject, teacher, class, room).
                $mergedSchedules = [];
                $values = $schedules->values();
                $count = $values->count();
                $i = 0;
                while ($i < $count) {
                    $first = $values[$i];
                    $group = [$first];
                    $startPeriod = $first->period;
                    $endPeriod = $first->period;

                    // Helper to build a join key for schedule items
                    // Merge only when the subject is the same and the items are consecutive.
                    $getKey = function ($it) {
                        return [
                            'subject' => $it->subject?->id ?? null,
                        ];
                    };

                    while (($i + 1) < $count) {
                        $next = $values[$i + 1];
                        $currentOrdinal = $endPeriod?->ordinal;
                        $nextOrdinal = $next->period?->ordinal;

                        // If ordinals are missing, or not consecutive, stop merging
                        if (!$currentOrdinal || !$nextOrdinal) break;
                        if (((int) $nextOrdinal) !== ((int) $currentOrdinal) + 1) break;

                        // Ensure same core properties before merging
                        if ($getKey($first) !== $getKey($next)) break;

                        // Merge: include next in the group and update endPeriod
                        $group[] = $next;
                        $endPeriod = $next->period;
                        $i++;
                    }

                    // Build label like "Jam ke 1" or "Jam ke 1 & 2"
                    $ordinalLabel = $startPeriod?->ordinal ? 'Jam ke ' . $startPeriod->ordinal : null;
                    if (count($group) > 1 && $startPeriod?->ordinal && $endPeriod?->ordinal) {
                        $sep = count($group) === 2 ? ' & ' : ' - ';
                        $ordinalLabel = 'Jam ke ' . $startPeriod->ordinal . $sep . $endPeriod->ordinal;
                    }

                    // Determine start and end times using the start/end periods
                    $startTimeStr = $startPeriod?->start_time ?? $startPeriod?->start_date?->format('H:i:s');
                    $endTimeStr = $endPeriod?->end_time ?? $endPeriod?->end_date?->format('H:i:s');

                    // Use the first element's subject/teacher/template/room data as the main info
                    $firstItem = $group[0];

                    $mergedSchedules[] = (object) [
                        'group' => $group,
                        'start_period' => $startPeriod,
                        'end_period' => $endPeriod,
                        'start_time' => $startTimeStr,
                        'end_time' => $endTimeStr,
                        'ordinal_label' => $ordinalLabel,
                        'subject' => $firstItem->subject ?? null,
                        'teacher' => $firstItem->teacher ?? null,
                        'template' => $firstItem->template ?? null,
                        'roomHistory' => $firstItem->roomHistory ?? null,
                        'day_of_week' => $firstItem->day_of_week ?? $day,
                        'first' => $firstItem,
                    ];

                    $i++;
                }
            @endphp

            @if(collect($mergedSchedules)->isEmpty())
                <div class="p-3 mb-3 border rounded-lg bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-center">
                    <div class="mx-auto mb-3 text-gray-400 dark:text-gray-600 inline-block">
                        <x-heroicon-o-book-open class="w-8 h-8 text-gray-400 dark:text-gray-600" />
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Tidak ada jadwal untuk hari ini.</p>
                </div>
            @else
                {{-- Calculated at top; no duplicate assignments here --}}
                
                {{-- Card Grid Layout (tighter columns for a cleaner grid) --}}
                <div class="grid gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 items-stretch mb-4">
                    @foreach($mergedSchedules as $item)
                        @php
                            // Merged period info
                            $periodStart = $item->start_period;
                            $periodEnd = $item->end_period;

                            // start/end string with fallback
                            $startTimeStr = $item->start_time ?? ($periodStart?->start_time ?? $periodStart?->start_date?->format('H:i:s'));
                            $endTimeStr = $item->end_time ?? ($periodEnd?->end_time ?? $periodEnd?->end_date?->format('H:i:s'));

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

                            $isOngoing = ((int) $item->day_of_week === (int) $currentDayIndex) && $startCarbon && $endCarbon ? ($currentTime->between($startCarbon, $endCarbon)) : false;
                            $isPast = ((int) $item->day_of_week === (int) $currentDayIndex) && $endCarbon ? ($endCarbon->lt($currentTime)) : false;
                        @endphp

                        <div class="group relative text-sm">
                            {{-- Card Container --}}
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
                                                    {{ $startTimeStr ? \Carbon\Carbon::parse($startTimeStr)->format('H:i') : ($periodStart?->start_date?->format('H:i') ?? '-') }}
                                            </div>
                                            <div class="text-[10px] opacity-75 mt-1">Mulai</div>
                                        </div>
                                        
                                        <div class="flex-1 flex items-center justify-center px-1">
                                            <x-heroicon-o-book-open class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                                        </div>
                                        
                                        <div class="text-center min-w-[48px]">
                                            <div class="text-sm font-semibold">
                                                {{ $endTimeStr ? \Carbon\Carbon::parse($endTimeStr)->format('H:i') : ($periodEnd?->end_date?->format('H:i') ?? '-') }}
                                            </div>
                                            <div class="text-[10px] opacity-75 mt-1">Selesai</div>
                                        </div>
                                        

                                    </div>

                                    {{-- Subject Info --}}
                                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-gray-200 dark:border-gray-700">
                                        @if($item->ordinal_label)
                                            <div class="ml-1 px-2 py-0.5 bg-white/10 backdrop-blur-sm rounded-full text-[11px] font-semibold">
                                                {{ $item->ordinal_label }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                                                {{ $item->subject?->name ?? $item->first->subject?->name ?? '-' }}
                                            </h4>
                                            @if($item->subject?->code)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800/30 dark:text-gray-300">
                                                {{ $item->subject?->code ?? $item->first->subject?->code }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Teacher Info with Avatar --}}
                                        <div class="mb-2 flex items-center gap-2 p-2 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900">
                                                <img src="{{ $item->teacher?->avatar ?? $item->first->teacher?->avatar ?? asset('images/default-teacher.png') }}"
                                            alt="Guru"
                                            class="w-8 h-8 rounded-full object-cover border-2 shadow-sm
                                            {{ $isOngoing ? 'border-gray-300 ring-1 ring-gray-200 dark:ring-gray-700' : 'border-gray-200 dark:border-gray-600' }}">
                                        <div class="flex-1">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pengajar</p>
                                            <p class="font-semibold text-gray-900 dark:text-white text-sm truncate">
                                                {{ $item->teacher?->user?->name ?? $item->teacher?->name ?? $item->first->teacher?->user?->name ?? $item->first->teacher?->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Location Info - Stacked --}}
                                    <div class="space-y-3">
                                        {{-- Class --}}
                                        <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700">
                                                <div class="flex-shrink-0 w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center shadow">
                                                    <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-white" />
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Kelas</p>
                                                <p class="font-medium text-gray-900 dark:text-white text-xs truncate">
                                                    {{ $item->template?->class?->full_name ?? $item->first->template?->class?->full_name ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Room --}}
                                        <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700">
                                            <div class="flex-shrink-0 w-8 h-8 bg-gray-600 rounded-lg flex items-center justify-center shadow">
                                                <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-white" />
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Ruangan</p>
                                                    <p class="font-medium text-gray-900 dark:text-white text-xs truncate">
                                                    {{ $item->roomHistory?->room?->building?->name ?? $item->first->roomHistory?->room?->building?->name ?? '-' }}
                                                </p>
                                                @if($item->roomHistory?->room?->building?->name)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        📍 {{ $item->roomHistory->room->building->name }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div> {{-- end grid --}}
                @endif
            @endforeach
        </main>

            {{-- Desktop: Right sidebar, inline with content --}}
            <aside class="hidden xl:block w-56 lg:sticky lg:top-28 lg:h-[calc(100vh-7rem)] lg:overflow-auto lg:flex-shrink-0" style="height: calc(100vh - 10rem);">
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-2 shadow-md h-full">
                    @for ($d = 1; $d <= 7; $d++)
                        <a href="#day-{{ $d }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors duration-150 hover:bg-gray-100 dark:hover:bg-gray-800 {{ $d === $currentDayIndex ? 'bg-gray-100 dark:bg-gray-900/20' : '' }}">
                            <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                            <span class="text-sm text-gray-700 dark:text-gray-200">{{ $dayNames[$d] }}</span>
                        </a>
                    @endfor
                </div>
            </aside>
        </div>

    {{-- Mobile: Floating menu (bottom-right) --}}
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