<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="relative h-40 overflow-hidden rounded-2xl 
                    bg-gradient-to-r from-gray-50 to-gray-100 
                    dark:from-gray-700 dark:to-gray-800
                    shadow-sm">

                    <!-- Soft top light -->
                    <div class="absolute inset-0 bg-gradient-to-b 
                        from-white/40 to-transparent 
                        dark:from-white/10"></div>

                    <!-- Decorative blur circles -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 
                        bg-white/50 dark:bg-white/5 
                        blur-3xl rounded-full"></div>

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
                            @if(isset($teacher) && $teacher->avatar)
                                <img src="{{ $teacher->avatar }}" 
                                     alt="Avatar of {{ $user->name }}" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                            @else
                                @php
                                    $initials = $user->initials();
                                @endphp
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center border-4 border-white dark:border-gray-800 shadow-lg">
                                    <span class="text-4xl text-gray-600 dark:text-gray-300 font-semibold">{{ $initials ?: 'U' }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Name and Role -->
                        <div class="sm:ml-6 text-center sm:text-left flex-1 z-10">
                            <h3 class="text-4xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $user->email }}
                            </p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                    {{ $user->role->name ?? 'User' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-4 sm:mt-0">
                            <a href="{{ route('profile.edit') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Identity -->
                        <div class="lg:col-span-1">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            Informasi Identitas
                                        </h4>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Code / NIP -->
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kode Pegawai</div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $teacher->code ?? '-' }}</div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Telepon</div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $teacher->phone ?? '-' }}</div>
                                        </div>

                                        <!-- Email -->
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Email</div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 break-all">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work & Academic Info -->
                        <div class="lg:col-span-2">
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center mb-6">
                                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Pekerjaan</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Subjects -->
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Mata Pelajaran</div>
                                                    <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                        @if(isset($teacher) && $teacher->subjects && $teacher->subjects->count())
                                                            <ul class="list-disc list-inside">
                                                                @foreach($teacher->subjects as $subject)
                                                                    <li>{{ $subject->name }} <span class="text-xs text-gray-500">({{ $subject->code ?? '' }})</span></li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Wali Kelas / Guardian Class -->
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Wali Kelas</div>
                                                    <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $guardian?->class?->full_name ?? '-' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Role Assignments (Head or Coordinator) -->
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150 col-span-2">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tugas & Jabatan</div>
                                                    <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                        {{-- Show if teacher is head of major or program coordinator via role assignments --}}
                                                        @php
                                                            $assignedRoles = [];
                                                        @endphp
                                                        @if(isset($teacher))
                                                            @foreach($teacher->roleAssignments as $ra)
                                                                @php
                                                                    $assignedRoles[] = 'Kepala Jurusan ' . ($ra->major?->name ?? $ra->major?->code ?? '-');
                                                                @endphp
                                                            @endforeach
                                                            @foreach($teacher->asCoordinatorAssignments as $ca)
                                                                @php
                                                                    $assignedRoles[] = 'Koordinator Program ' . ($ca->major?->name ?? $ca->major?->code ?? '-');
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                        @if(count($assignedRoles))
                                                            <ul class="list-disc list-inside">
                                                                @foreach($assignedRoles as $ar)
                                                                    <li>{{ $ar }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
