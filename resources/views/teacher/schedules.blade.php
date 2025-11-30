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
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold">{{ $teacherFullName }}</h3>
                    <p class="text-sm text-gray-500">Jadwal mengajar minggu ini</p>
                </div>
            </div>

            {{-- Mobile-only: Pelajaran Saya under the header --}}
            <div class="xl:hidden mt-3">
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-3 shadow-sm">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Pelajaran Saya</h4>
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
                            <x-heroicon-o-academic-cap class="w-5 h-5 text-gray-500" />
                            <div class="ml-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Mata Pelajaran</p>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $totalSubjects }}</p>
                            </div>
                            <div class="mt-2 sm:mt-0 sm:flex-1">
                                <ul class="flex flex-wrap gap-2">
                                    @foreach($subjects as $subject)
                                        <li class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-800 text-sm text-gray-700 dark:text-gray-200">{{ $subject->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($allSchedules as $day => $schedules)
                <div class="mt-4 mb-2 flex items-center gap-2 scroll-mt-28" id="day-{{ $day }}">
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                    <h3 class="text-base md:text-xl font-semibold tracking-wide px-3 py-1 bg-gray-50 dark:bg-gray-800/30 rounded-full text-gray-900 dark:text-gray-100 shadow-sm">
                        {{ $dayNames[$day] ?? 'Hari' }}
                    </h3>
                    <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                </div>

                @php
                    $mergedSchedules = [];
                    $values = $schedules->values();
                    $count = $values->count();
                    $i = 0;
                    while ($i < $count) {
                        $first = $values[$i];
                        $group = [$first];
                        $startPeriod = $first->period;
                        $endPeriod = $first->period;

                        $getKey = function ($it) {
                            return [
                                'subject' => $it->subject?->id ?? null,
                                'class_id' => $it->template?->class?->id ?? null,
                            ];
                        };

                        while (($i + 1) < $count) {
                            $next = $values[$i + 1];
                            $currentOrdinal = $endPeriod?->ordinal;
                            $nextOrdinal = $next->period?->ordinal;

                            if (!$currentOrdinal || !$nextOrdinal) break;
                            if (((int) $nextOrdinal) !== ((int) $currentOrdinal) + 1) break;
                            if ($getKey($first) !== $getKey($next)) break;

                            $group[] = $next;
                            $endPeriod = $next->period;
                            $i++;
                        }

                        $ordinalLabel = $startPeriod?->ordinal ? 'Jam ke ' . $startPeriod->ordinal : null;
                        if (count($group) > 1 && $startPeriod?->ordinal && $endPeriod?->ordinal) {
                            $sep = count($group) === 2 ? ' & ' : ' - ';
                            $ordinalLabel = 'Jam ke ' . $startPeriod->ordinal . $sep . $endPeriod->ordinal;
                        }

                        $startTimeStr = $startPeriod?->start_time ?? $startPeriod?->start_date?->format('H:i:s');
                        $endTimeStr = $endPeriod?->end_time ?? $endPeriod?->end_date?->format('H:i:s');

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
                    <div class="p-3 mb-3 border rounded-lg bg-gray-50 dark:bg-gray-800/50 border-gray-100 dark:border-gray-800 text-center">
                        <div class="mx-auto mb-3 text-gray-400 dark:text-gray-600 inline-block">
                            <x-heroicon-o-book-open class="w-8 h-8 text-gray-400 dark:text-gray-600" />
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 font-medium text-sm">Tidak ada jadwal untuk hari ini.</p>
                    </div>
                @else
                    <div class="grid gap-3 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 items-stretch mb-4">
                        @foreach($mergedSchedules as $item)
                            @php
                                $periodStart = $item->start_period;
                                $periodEnd = $item->end_period;
                                $startTimeStr = $item->start_time ?? ($periodStart?->start_time ?? $periodStart?->start_date?->format('H:i:s'));
                                $endTimeStr = $item->end_time ?? ($periodEnd?->end_time ?? $periodEnd?->end_date?->format('H:i:s'));
                                try { $startCarbon = $startTimeStr ? \Carbon\Carbon::parse($startTimeStr) : null; } catch (\Exception $e) { $startCarbon = null; }
                                try { $endCarbon = $endTimeStr ? \Carbon\Carbon::parse($endTimeStr) : null; } catch (\Exception $e) { $endCarbon = null; }
                                $isOngoing = ((int) $item->day_of_week === (int) $currentDayIndex) && $startCarbon && $endCarbon ? ($currentTime->between($startCarbon, $endCarbon)) : false;
                                $isPast = ((int) $item->day_of_week === (int) $currentDayIndex) && $endCarbon ? ($endCarbon->lt($currentTime)) : false;
                            @endphp

                            {{-- Teacher POV Card --}}
                            <div class="group relative text-sm">
                                <div class="relative rounded-xl overflow-hidden transition-all duration-150 h-full
                                    {{ $isOngoing
                                        ? 'bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 scale-100'
                                        : ($isPast
                                            ? 'bg-gray-50 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-800 opacity-70'
                                            : 'bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:shadow-sm')
                                    }}">
                                        <div class="h-1 {{ $isOngoing ? 'bg-gray-300 dark:bg-gray-700 animate-pulse' : 'bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600' }}"></div>

                                    @if ($isOngoing)
                                        <div class="absolute top-3 right-3 z-10">
                                            <div class="bg-gray-700 text-white px-3 py-1 rounded-full shadow flex items-center gap-2 animate-bounce">
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

                                    <div class="p-3">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 pr-2">
                                                <h4 class="text-base md:text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1 truncate">
                                                    {{ $item->subject?->name ?? $item->first->subject?->name ?? '-' }}
                                                </h4>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800/30 dark:text-gray-300">
                                                        {{ $item->subject?->code ?? $item->first->subject?->code ?? '' }}
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Kelas</div>
                                                <div class="font-semibold text-gray-900 dark:text-white text-sm">
                                                    {{ $item->template?->class?->full_name ?? $item->first->template?->class?->full_name ?? ($item->first->template?->class?->name ?? '-') }}
                                                </div>
                                            </div>

                                            {{-- Time block --}}
                                            <div class="text-right min-w-[80px]">
                                                    <div class="text-sm font-semibold">
                                                    {{ $startTimeStr ? \Carbon\Carbon::parse($startTimeStr)->format('H:i') : ($periodStart?->start_date?->format('H:i') ?? '-') }}
                                                    -
                                                    {{ $endTimeStr ? \Carbon\Carbon::parse($endTimeStr)->format('H:i') : ($periodEnd?->end_date?->format('H:i') ?? '-') }}
                                                </div>
                                                @if($item->ordinal_label)
                                                    <div class="text-[11px] mt-1 text-gray-500">{{ $item->ordinal_label }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mt-3 grid grid-cols-2 gap-2">
                                            <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900">
                                                <x-heroicon-o-building-office-2 class="w-5 h-5 text-gray-500" />
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Ruangan</p>
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                        {{ $item->roomHistory?->room?->name ?? $item->first->roomHistory?->room?->name ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2 p-2 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900">
                                                <x-heroicon-o-user class="w-5 h-5 text-gray-500" />
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Pengajar</p>
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm truncate">
                                                        {{ $teacherFullName }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach

        </main>

        <aside class="hidden xl:block w-56 lg:sticky lg:top-28 lg:h-[calc(100vh-7rem)] lg:overflow-auto lg:flex-shrink-0" style="height: calc(100vh - 10rem);">
            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-lg p-2 shadow-md">
                @for ($d = 1; $d <= 7; $d++)
                    <a href="#day-{{ $d }}" class="flex items-center gap-2 px-3 py-2 rounded-md transition-colors duration-150 hover:bg-gray-100 dark:hover:bg-gray-800 {{ $d === $currentDayIndex ? 'bg-gray-50 dark:bg-gray-800/20' : '' }}">
                        <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $dayNames[$d] }}</span>
                    </a>
                @endfor
            </div>
            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-lg p-3 shadow-md mt-5">
                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Pelajaran Saya</h4>
                <div class="space-y-3">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-academic-cap class="w-5 h-5 text-gray-500" />
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Mata Pelajaran</p>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $totalSubjects }}</p>
                            </div>
                        </div>
                        <div>
                            <ul class="flex flex-wrap gap-2">
                                @foreach($subjects as $subject)
                                    <li class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-800 text-sm text-gray-700 dark:text-gray-200">{{ $subject->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

            <div class="xl:hidden fixed bottom-4 right-4 z-50 flex items-end justify-end">
        <div class="relative">
            <button id="dayToggleBtn" aria-expanded="false" aria-controls="dayMenu" class="bg-gray-700 p-3 rounded-full shadow-md text-white focus:outline-none">
                <x-heroicon-o-book-open class="w-5 h-5 text-white" />
            </button>
            <div id="dayMenu" class="hidden absolute right-0 bottom-14 w-44 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-lg shadow-md p-2">
                @for ($d = 1; $d <= 7; $d++)
                    <a href="#day-{{ $d }}" onclick="document.getElementById('dayMenu').classList.add('hidden')" class="flex items-center gap-2 px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800">
                        <x-heroicon-o-book-open class="w-4 h-4 text-gray-600 dark:text-gray-300" />
                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $dayNames[$d] }}</span>
                    </a>
                @endfor
            </div>
        </div>
    </div>

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