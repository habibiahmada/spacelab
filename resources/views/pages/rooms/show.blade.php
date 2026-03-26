<x-guest-layout title="Detail Ruangan" description="Lihat detail ruangan, jadwal, dan penggunaan">
    <style>
        .is-fullscreen footer { display: none !important; }
        .is-fullscreen main { margin-top: 0 !important; }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
    </style>

    <section 
        x-data="{ isFullscreen: false }" 
        @fullscreenchange.window="isFullscreen = !!document.fullscreenElement"
        :class="isFullscreen ? 'pt-6 pb-4 h-screen overflow-hidden' : 'pt-28 pb-20 min-h-screen overflow-auto'"
        class="px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-900 flex flex-col transition-all duration-300">
        <div class="max-w-6xl mx-auto w-full flex-1 flex flex-col min-h-0">
            <div class="flex items-center justify-between mb-4 flex-shrink-0">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                    <a href="{{ route('views.index') }}"
                        class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Views</a>
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                    <a href="{{ route('views.rooms') }}"
                        class="hover:text-slate-700 dark:hover:text-slate-300 transition-colors">Ruangan</a>
                    <x-heroicon-o-chevron-right class="w-4 h-4" />
                    <span class="text-slate-900 dark:text-white font-medium">{{ $room->name }}</span>
                </nav>

                {{-- tombol fullscreen --}}
                <x-primary-button class="inline-flex items-center max-w-fit py-1.5" onclick="toggleFullscreen()" id="fullscreenBtn">
                    <x-heroicon-o-arrows-pointing-out class="w-4 h-4 mr-2" />
                    Fullscreen
                </x-primary-button>
            </div>

            {{-- Room Info Card --}}
            <div
                class="bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 p-4 mb-4 flex-shrink-0">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center">
                                <x-heroicon-o-building-office-2 class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-slate-900 dark:text-white leading-tight">{{ $room->name }}</h1>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $room->code }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-2">
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Gedung</p>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ $room->building?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lantai</p>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $room->floor ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kapasitas</p>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ $room->capacity ?? '-' }} orang</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tipe</p>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">
                                {{ ucfirst($room->type ?? '-') }}</p>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="flex-shrink-0">
                        @if ($ongoingEntry)
                            <div
                                class="bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 rounded-xl px-4 py-2 text-center min-w-[140px]">
                                <span
                                    class="flex items-center justify-center gap-1.5 text-xs font-medium text-amber-700 dark:text-amber-400">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Berlangsung
                                </span>
                                <p class="text-[10px] font-bold text-amber-600 dark:text-amber-400/80 uppercase truncate max-w-[120px]">
                                    {{ $ongoingEntry->template?->class?->full_name ?? '-' }}
                                </p>
                            </div>
                        @else
                            <div
                                class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 rounded-xl px-4 py-2 text-center min-w-[140px]">
                                <span
                                    class="flex items-center justify-center gap-1.5 text-xs font-medium text-emerald-700 dark:text-emerald-400">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Kosong
                                </span>
                                <p class="text-[10px] text-emerald-600 dark:text-emerald-400/80">Tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1 min-h-0">
                {{-- Today's Schedule --}}
                <div 
                    class="lg:col-span-2 bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col min-h-0">
                    <div class="px-6 py-3 border-b border-slate-200 dark:border-slate-800 flex-shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-slate-900 dark:text-white">Jadwal Hari Ini</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $dayName }}, {{ $today->translatedFormat('d F Y') }}</p>
                        </div>
                        <span class="text-[10px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-full">
                            {{ $todayEntries->count() }} Sesi
                        </span>
                    </div>

                    <div class="flex-1 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800 custom-scrollbar">
                        @if ($todayEntries->isNotEmpty())
                            @foreach ($todayEntries as $entry)
                                @php
                                    $isOngoing = $entry->isOngoing($now);
                                    $isPast = $entry->isPast($now);
                                @endphp
                                <div
                                    class="px-6 py-3 flex items-center gap-4 {{ $isOngoing ? 'bg-amber-50/50 dark:bg-amber-900/10 border-l-4 border-l-amber-500' : ($isPast ? 'opacity-50' : '') }}">
                                    {{-- Time --}}
                                    <div class="flex-shrink-0 text-center min-w-[70px]">
                                        <p class="text-sm font-mono font-bold text-slate-900 dark:text-white">
                                            {{ $entry->period?->start_time ? \Carbon\Carbon::parse($entry->period->start_time)->format('H:i') : '--:--' }}
                                        </p>
                                        <p class="text-[10px] font-mono text-slate-400 dark:text-slate-500">
                                            {{ $entry->period?->end_time ? \Carbon\Carbon::parse($entry->period->end_time)->format('H:i') : '--:--' }}
                                        </p>
                                    </div>

                                    {{-- Indicator --}}
                                    <div class="flex-shrink-0">
                                        @if ($isOngoing)
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse block"></span>
                                        @elseif($isPast)
                                            <span class="w-2.5 h-2.5 rounded-full bg-slate-300 dark:bg-slate-700 block"></span>
                                        @else
                                            <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-200 dark:border-slate-800 block"></span>
                                        @endif
                                    </div>

                                    {{-- Entry Info --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                            {{ $entry->teacherSubject?->subject?->name ?? 'Mata Pelajaran' }}
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">
                                                {{ $entry->template?->class?->full_name ?? '-' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 truncate hidden sm:inline">
                                                • {{ $entry->teacherSubject?->teacher?->user?->name ?? '-' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Status Label --}}
                                    <div class="flex-shrink-0 text-right">
                                        @if ($isOngoing)
                                            <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-tight">Aktif</span>
                                        @elseif($isPast)
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium lowercase">selesai</span>
                                        @else
                                            <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium lowercase">nanti</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="h-full flex flex-col items-center justify-center py-12 text-center opacity-40">
                                <x-heroicon-o-calendar class="w-12 h-12 mb-3" />
                                <p class="text-sm">Tidak ada jadwal hari ini</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- QR Code Section --}}
                <div class="flex flex-col gap-6 flex-shrink-0 min-w-0">
                    @if ($activeSession)
                        <div class="bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 p-6 flex flex-col items-center justify-center text-center">
                            <h2 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">Absensi Digital</h2>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 mb-4">Scan untuk melakukan presensi</p>
                            
                            <div class="bg-white p-3 rounded-lg shadow-sm mb-4 border border-slate-100">
                                <div id="qr-code-room"></div>
                            </div>
                            
                            <div class="flex items-center gap-2 text-xs">
                                <span class="bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full font-mono font-bold text-slate-700 dark:text-slate-300">
                                    {{ $activeSession->token }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <div class="bg-slate-900 dark:bg-black rounded-xl p-6 text-white flex-1 flex flex-col justify-center relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-all duration-700"></div>
                        <h3 class="text-2xl font-black italic tracking-tighter mb-2 relative z-10">SPACELAB</h3>
                        <p class="text-xs text-slate-400 relative z-10 leading-relaxed font-light">
                            Sistem Pemantauan dan Administrasi <br> Cerdas Laboratorium
                        </p>
                        <div class="mt-auto pt-6 flex items-center gap-2 relative z-10 text-[10px] font-mono text-slate-500">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            SYSTEM OPERATIONAL
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
            <script>
                document.addEventListener('alpine:init', () => {
                    @if($activeSession)
                    const qr = qrcode(0, 'M');
                    qr.addData('{{ $activeSession->token }}');
                    qr.make();
                    const el = document.getElementById('qr-code-room');
                    if (el) el.innerHTML = qr.createImgTag(5, 0);
                    @endif

                    window.toggleFullscreen = function() {
                        const elem = document.documentElement;
                        if (!document.fullscreenElement) {
                            elem.requestFullscreen();
                            document.body.classList.add('is-fullscreen');
                        } else {
                            document.exitFullscreen();
                        }
                    }

                    document.addEventListener('fullscreenchange', () => {
                        if (!document.fullscreenElement) {
                            document.querySelector('nav').classList.remove('hidden');
                            document.querySelector('footer').classList.remove('hidden');
                            document.getElementById('fullscreenBtn').classList.remove('hidden');
                            document.body.classList.remove('is-fullscreen');
                        } else {
                            document.querySelector('nav').classList.add('hidden');
                            document.querySelector('footer').classList.add('hidden');
                            document.getElementById('fullscreenBtn').classList.add('hidden');
                        }
                    });
                });
            </script>
        </div>
    </section>
</x-guest-layout>
