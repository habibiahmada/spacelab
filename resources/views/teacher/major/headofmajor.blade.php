<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jurusan bagian kepala jurusan') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div>
            <!-- Header Card with Avatar -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150 mb-6">
                <div class="relative h-40 overflow-hidden rounded-xl 
                    bg-gradient-to-r from-gray-50 to-gray-100 
                    dark:from-gray-700 dark:to-gray-800
                    shadow-sm">

                    <div class="absolute -bottom-10 -right-10 w-44 h-44 
                        bg-gray-200/60 dark:bg-gray-600/40 
                        blur-3xl rounded-full"></div>

                    <!-- Subtle bottom border glow -->
                    <div class="absolute bottom-0 left-0 right-0 h-px 
                        bg-gradient-to-r from-transparent via-gray-300 to-transparent
                        dark:via-gray-600"></div>
                </div>
                <div class="px-6 pb-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16 sm:-mt-12">
                        <!-- Avatar -->
                        <div class="relative mb-4 sm:mb-0">
                                  <img src="{{ $major && $major->logo ? asset($major->logo) : asset('assets/images/avatar/default-profile.png') }}" 
                                     alt="Avatar of username" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                        </div>

                        <!-- Name and Role -->
                        <div class="sm:ml-6 text-center sm:text-left flex-1 z-0">
                            <h3 class="text-4xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $major?->name ?? '— Tidak ada jurusan —' }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $major?->code ?? '' }}
                            </p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    {{ $major?->slogan ?? 'Tidak ada deskripsi.' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4 sm:mt-0">
                            <a href="#" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>  
                    </div>
                    <div class="mt-6">
                        <p class="mt-6 text-gray-600 dark:text-gray-300 text-justify">
                            {{ $major?->description ?? 'Detail jurusan belum diset.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 md:gap-6">

        <!-- Card 1: Pelajaran Hari Ini -->
        <article role="article" aria-label="Pelajaran Hari Ini"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Total Kelas</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white">{{ $stats['class_count'] ?? 0 }}</h3>
                    {{-- <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2"></p> --}}
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

        {{-- Card 2: Total Siswa di jurusan --}}
        <article role="article" aria-label="Pelajaran Hari Ini"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Total Siswa</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white">{{ $stats['student_count'] ?? 0 }}</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">Siswa</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-book-open class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

        <!-- Card 2: Hari Ini -->
        <article role="article" aria-label="Hari Ini"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Hari Ini</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white capitalize">Senin</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">07.45</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-calendar class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

        <!-- Card 3: Jumlah Ruangan -->
        <article role="article" aria-label="Jumlah Ruangan"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Jumlah ruangan</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white">{{ $stats['room_count'] ?? 0 }}</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">jurusan</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-building-office-2 class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

        <!-- Card 5: Total Pelajaran Jurusan -->
        <article role="article" aria-label="Total Pelajaran Jurusan"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Pelajaran Jurusan</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white truncate">{{ $subjectCount ?? ($majorSubjects->count() ?? 0) }}</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">Mapel</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-academic-cap class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

        <!-- Card 6: Jumlah Guru Jurusan -->
        <article role="article" aria-label="Jumlah Guru Jurusan"
            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Guru Jurusan</p>
                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white truncate">{{ $teacherCount ?? (is_countable($teachers) ? count($teachers) : 0) }}</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2">Guru</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-2 md:p-3 rounded-lg flex items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="sr-only">Icon</span>
                    <x-heroicon-o-user-group class="w-5 h-5 md:w-6 md:h-6 text-gray-500 dark:text-gray-100" aria-hidden="true" />
                </div>
            </div>
        </article>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-6 py-12">
        <!-- Class List - 2/3 width -->
        <div class="lg:col-span-2">
            <div>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150">
                    <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-heroicon-o-users class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 dark:text-gray-200" />
                                Daftar Kelas jurusan ini
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            @if($classes->isEmpty())
                                <p class="text-sm text-gray-500">Tidak ada kelas untuk jurusan ini.</p>
                            @else
                                <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($classes as $class)
                                        <li class="py-3 flex items-center justify-between">
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $class->full_name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Siswa: {{ $class->students_count ?? 0 }}</div>
                                            </div>
                                            <div class="flex-shrink-0 text-xs text-gray-400">
                                                <a href="#">Lihat Detail</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-3">
                                    @if(method_exists($classes, 'links'))
                                        {{ $classes->appends(request()->except('classes_page'))->links() }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-10 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150">
                    <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-heroicon-o-users class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 dark:text-gray-200" />
                                Daftar Guru jurusan
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            @if($teachers->isEmpty())
                                <p class="text-sm text-gray-500">Belum ada guru yang terhubung ke jurusan ini.</p>
                            @else
                                <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($teachers as $t)
                                        <li class="py-3 flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $t->teacher?->avatar ?? $t->avatar ?? asset('assets/images/avatar/default-profile.png') }}" alt="{{ $t->user?->name ?? 'Guru' }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700 shadow-sm" />
                                                <div class="min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $t->user?->name ?? '—' }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $t->code ?? '' }}</div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-3">
                                    @if(method_exists($teachers, 'links'))
                                        {{ $teachers->appends(request()->except('teachers_page'))->links() }}
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <div class="bg-white  dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150">
                        <!-- Current Day Info -->
                        <div class="p-3 mb-5 sm:p-5 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center shadow-sm">
                                    <x-heroicon-o-calendar class="w-5 h-5 sm:w-6 sm:h-6 text-gray-700 dark:text-gray-200" />
                                </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Hari Ini</p>
                                    <div class="flex justify-between items-center gap-4">
                                        <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white">{{ now()->translatedFormat('l, d F Y') }}</p>
                                            <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white">{{ now()->translatedFormat('H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <article role="article" aria-label="Kepala Jurusan"
                            class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Kepala Jurusan</p>
                                    <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white truncate">{{ $assignment?->head?->user?->name ?? 'Belum diset' }}</h3>
                                    {{-- <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2"></p> --}}
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="bg-gray-50 dark:bg-gray-800 p-1 md:p-2 rounded-full border border-gray-100 dark:border-gray-700">
                                    <img src="{{ $major && $major->logo ? asset($major->logo) : asset('assets/images/avatar/default-profile.png') }}" alt="Avatar Guru" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover shadow" />
                                </div>
                            </div>
                        </div>
                    </article>        
                    <article role="article" aria-label="Kepala Jurusan"
                        class="bg-white dark:bg-gray-900 shadow-sm rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 p-4 md:p-5 hover:shadow-md transition-all duration-150">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">Kepala Program</p>
                                <h3 class="text-sm md:text-2xl font-extrabold text-gray-900 dark:text-white truncate">{{ $assignment?->programCoordinator?->user?->name ?? 'Belum diset' }}</h3>
                                {{-- <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 mt-2"></p> --}}
                            </div>
                            <div class="flex-shrink-0">
                                <div class="bg-gray-50 dark:bg-gray-800 p-1 md:p-2 rounded-full border border-gray-100 dark:border-gray-700">
                                    <img src="{{ $major && $major->logo ? asset($major->logo) : asset('assets/images/avatar/default-profile.png') }}" alt="Avatar Guru" class="w-8 h-8 md:w-10 md:h-10 rounded-full object-cover shadow" />
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- Perusahaan -->
                    <div class="mt-10 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150">
                        <div class="p-3 sm:p-5 border-b border-gray-100 dark:border-gray-800">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide flex items-center gap-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                                Perusahaan
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            <h4 class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Perusahaan Mitra</h4>
                            @if($companies->isEmpty())
                                <p class="text-sm text-gray-500">Belum ada perusahaan yang bekerja sama dengan jurusan ini.</p>
                            @else
                                <div class="flex items-center gap-3 overflow-x-auto py-2">
                                    @foreach($companies as $rel)
                                        @php $company = $rel->company; @endphp
                                        <a href="{{ $company?->website ?? '#' }}" target="_blank" class="block hover:opacity-90">
                                            <img src="{{ $company && $company->logo ? asset($company->logo) : asset('assets/images/company/default.png') }}"
                                                alt="{{ $company?->name ?? 'Perusahaan' }}"
                                                class="w-16 h-16 object-contain rounded-md border bg-white"
                                                title="{{ $company?->name ?? 'Perusahaan' }}" />
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- Daftar Mapel Jurusan --}}
                    <div class="mt-10 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-all duration-150">
                        <div class="p-3 sm:p-5 border-b border-gray-100 dark:border-gray-800">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide flex items-center gap-2">
                                Pelajaran Jurusan
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            @if($majorSubjects->isEmpty())
                                <p class="text-sm text-gray-500">Belum ada pelajaran yang ditetapkan untuk jurusan ini.</p>
                            @else
                                <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($majorSubjects as $ms)
                                        <li class="py-3 flex items-center justify-between">
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $ms->subject?->name ?? '—' }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Kode: {{ $ms->subject?->code ?? '—' }}</div>
                                            </div>
                                            <div class="flex-shrink-0 text-xs text-gray-400">
                                                <a href="#">Lihat Detail</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>