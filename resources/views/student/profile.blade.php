<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div>
            <!-- Header Card with Avatar -->
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
                            @if(isset($student) && $student->avatar)
                                <img src="{{ $student->avatar }}" 
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
                
                <!-- Informasi Identitas -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Informasi Identitas
                                </h4>
                            </div>

                            <div class="space-y-4">
                                <!-- NIS -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        NIS
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $student->nis ?? '-' }}
                                    </div>
                                </div>

                                <!-- NISN -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        NISN
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $student->nisn ?? '-' }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        Email
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 break-all">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Akademik -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Informasi Akademik
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Kelas -->
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                Kelas
                                            </div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $classroom->full_name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wali Kelas -->
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
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                Wali Kelas
                                            </div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $guardian?->teacher?->user?->name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahun Ajaran -->
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
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                Tahun Ajaran
                                            </div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $term?->tahun_ajaran ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Block -->
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:border-gray-300 dark:hover:border-gray-600 transition duration-150">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                Block
                                            </div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $classHistory?->block?->name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Footer -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Data akademik diperbarui secara berkala setiap semester
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>