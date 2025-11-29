<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            Dashboard Siswa
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">

                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden 
                            border border-gray-100 dark:border-gray-800 p-4 md:p-5 
                            hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Pelajaran Hari Ini</p>
                            <h3 class="text-2xl md:text-5xl font-extrabold text-gray-900 dark:text-white">{{ $countToday }}</h3>
                            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">mata pelajaran</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center 
                                    border border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" />
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden 
                            border border-gray-100 dark:border-gray-800 p-4 md:p-5 
                            hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Hari Ini</p>
                            <h3 class="text-lg md:text-2xl font-semibold text-gray-900 dark:text-white capitalize">{{ $today }}</h3>
                            <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">{{ now()->format('d M Y') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center 
                                    border border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-calendar class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" />
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden 
                            border border-gray-100 dark:border-gray-800 p-4 md:p-5 
                            hover:shadow-md transition-all duration-150">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Nama Siswa</p>
                            <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white truncate">{{ $student->name }}</h3>
                            <p class="text-xs md:text-sm text-gray-400 dark:text-gray-500 mt-1 truncate">{{ $studentClassFullName ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex-shrink-0 flex items-center justify-center 
                                    border border-gray-100 dark:border-gray-700">
                            <img src="{{ $student->student->avatar ?? asset('images/default-student.png') }}"
                                alt="Avatar Siswa"
                                class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover border-2 shadow 
                                        border-gray-200 dark:border-gray-700">
                        </div>
                    </div>
                </div>

            </div>


            {{-- Jadwal Hari Ini --}}
            <div class="bg-white dark:bg-gray-900 shadow rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="bg-gray-100 dark:bg-gray-800 px-6 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm p-2 rounded-lg">
                                <x-heroicon-o-clock class="w-6 h-6 text-gray-600 dark:text-gray-100" />
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Jadwal Hari Ini</h3>
                                @if (!$schedulesToday->isEmpty())
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $schedulesToday->count() }} mata pelajaran</p>
                                @endif
                            </div>
                        </div>
                        @if (!$schedulesToday->isEmpty())
                            <div class="hidden sm:flex items-center gap-2 text-xs text-gray-600 dark:text-white/90">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 bg-blue-300 rounded-full animate-pulse"></span>
                                    <span class="hidden md:inline">Berlangsung</span>
                                </span>
                                <span class="text-gray-300 dark:text-gray-500">•</span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 bg-gray-300/40 rounded-full"></span>
                                    <span class="hidden md:inline">Selesai</span>
                                </span>
                                <span class="text-gray-300 dark:text-gray-500">•</span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 bg-white rounded-full"></span>
                                    <span class="hidden md:inline">Akan Datang</span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @if ($schedulesToday->isEmpty())
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full mb-5 shadow">
                                <span class="text-5xl">🎉</span>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Tidak ada pelajaran hari ini</h4>
                            <p class="text-gray-500 dark:text-gray-400">Nikmati hari liburmu dengan baik!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @php
                                $currentTime = $currentTime ?? \Carbon\Carbon::now();
                                $currentDayIndex = $currentDayIndex ?? (int) $currentTime->format('N');
                            @endphp

                            {{ $currentTime->toDateTimeString() }} (Hari: {{ $currentDayIndex }})
                            
                            @foreach ($schedulesToday as $schedule)
                                @php
                                    $startTime = $schedule->period?->start_date;
                                    $endTime = $schedule->period?->end_date;
                                    $period = $schedule->period;
                                    $isOngoing = ((int) $schedule->day_of_week === (int) $currentDayIndex) && ($schedule->isOngoing($currentTime) ?? false);
                                    $isPast = ((int) $schedule->day_of_week === (int) $currentDayIndex) && ($schedule->isPast($currentTime) ?? false);
                                @endphp

                                {{-- Developer debug: show timestamps when running locally --}}
                                @if (app()->isLocal())
                                    <div class="mt-2 text-xs text-gray-500">
                                        start_date: {{ optional($startTime)?->toDateTimeString() ?? '-'}} |
                                        end_date: {{ optional($endTime)?->toDateTimeString() ?? '-'}} |
                                        start_time: {{ optional($period)?->start_time ?? '-'}} |
                                        end_time: {{ optional($period)?->end_time ?? '-'}} |
                                        now: {{ $currentTime->toDateTimeString() }} |
                                        ongoing: {{ $isOngoing ? 'true' : 'false' }} |
                                        past: {{ $isPast ? 'true' : 'false' }} |
                                        schedule_day: {{ $schedule->day_of_week }}
                                    </div>
                                @endif

                                <div class="relative group">
                                    {{-- Ongoing Side Indicator --}}
                                    @if ($isOngoing)
                                        <div class="absolute -left-6 top-0 bottom-0 w-1.5 bg-blue-300 rounded-full shadow animate-pulse"></div>
                                    @endif

                                    <div class="
                                        relative overflow-hidden rounded-xl border-2 transition-all duration-300
                                        {{ $isOngoing 
                                            ? 'bg-blue-50 dark:bg-gray-900/10 border-blue-300 dark:border-blue-400 shadow scale-[1.01]' 
                                            : ($isPast 
                                                ? 'bg-gray-50 dark:bg-gray-800/30 border-gray-200 dark:border-gray-700 opacity-70' 
                                                : 'bg-white dark:bg-gray-900/20 border-gray-200 dark:border-gray-700  hover:shadow')
                                        }}
                                    ">
                                        {{-- Ongoing Badge --}}
                                        @if ($isOngoing)
                                            <div class="absolute top-0 right-0 bg-blue-300 text-gray-900 px-4 py-1.5 rounded-bl-xl shadow flex items-center gap-2 z-10">
                                                <span class="relative flex h-2.5 w-2.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                                                </span>
                                                <span class="text-xs font-bold tracking-wide">BERLANGSUNG</span>
                                            </div>
                                        @endif

                                        @if ($isPast)
                                            <div class="absolute top-3 right-3 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-1 rounded-full shadow-sm z-10">
                                                <span class="text-xs font-semibold">SELESAI</span>
                                            </div>
                                        @endif

                                        <div class="p-5">
                                            <div class="flex flex-col lg:flex-row gap-5">
                                                {{-- Time Section --}}
                                                <div class="flex-shrink-0">
                                                    <div class="
                                                        inline-flex flex-col items-center justify-center rounded-xl p-4 min-w-[100px] shadow
                                                        {{ $isOngoing 
                                                            ? 'bg-blue-300 text-gray-900 ring-2 ring-blue-100 dark:ring-blue-400' 
                                                            : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100'
                                                        }}
                                                    ">
                                                        <div class="text-3xl font-bold leading-none">
                                                            {{ optional($schedule->period)->start_time ? \Carbon\Carbon::createFromFormat('H:i:s', $schedule->period->start_time)->format('H:i') : ($schedule->period?->start_date?->format('H:i') ?? '-') }}
                                                        </div>
                                                        <div class="text-xs opacity-90 mt-1">s.d.</div>
                                                        <div class="text-lg font-semibold leading-none">
                                                            {{ optional($schedule->period)->end_time ? \Carbon\Carbon::createFromFormat('H:i:s', $schedule->period->end_time)->format('H:i') : ($schedule->period?->end_date?->format('H:i') ?? '-') }}
                                                        </div>
                                                        @if($schedule->period?->ordinal)
                                                            <div class="mt-2.5 px-3 py-1 bg-white/25 backdrop-blur-sm rounded-full">
                                                                <span class="text-xs font-bold">Jam {{ $schedule->period->ordinal }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Content Section --}}
                                                <div class="flex-1 min-w-0">
                                                    {{-- Subject --}}
                                                    <div class="mb-4">
                                                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1 leading-tight">
                                                            {{ $schedule->subject->name ?? '-' }}
                                                        </h4>
                                                        @if($schedule->subject->code)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                                {{ $schedule->subject->code }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- Info Grid --}}
                                                    <div class="grid md:grid-cols-3 gap-4">
                                                        {{-- Teacher --}}
                                                        <div class="flex items-center gap-3 bg-white dark:bg-gray-900 rounded-lg p-3 shadow border border-gray-100 dark:border-gray-800">
                                                            <img src="{{ $schedule->teacher->avatar ?? asset('images/default-teacher.png') }}"
                                                                alt="Guru"
                                                                class="w-11 h-11 rounded-full object-cover border-2 shadow
                                                                {{ $isOngoing ? 'border-blue-300 ring-2 ring-blue-100 dark:ring-blue-400' : 'border-gray-200 dark:border-gray-700' }}">
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Pengajar</p>
                                                                <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                                                    {{ $schedule->teacher->user->name ?? ($schedule->teacher->name ?? '-') }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        {{-- Class --}}
                                                        <div class="flex items-center gap-3 bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-100 dark:border-gray-700">
                                                            <div class="flex-shrink-0 w-11 h-11 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center shadow">
                                                                <x-heroicon-o-user-group class="w-6 h-6 text-white" />
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Kelas</p>
                                                                <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                                                    {{ $schedule->template?->class?->full_name ?? '-' }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        {{-- Room --}}
                                                        <div class="flex items-center gap-3 bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-100 dark:border-gray-700">
                                                            <div class="flex-shrink-0 w-11 h-11 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center shadow">
                                                                <x-heroicon-o-map-pin class="w-6 h-6 text-white" />
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">Ruangan</p>
                                                                <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">
                                                                    {{ $schedule->roomHistory?->room?->name ?? '-' }}
                                                                </p>
                                                                @if($schedule->roomHistory?->room?->building?->name)
                                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                                        {{ $schedule->roomHistory->room->building->name }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>