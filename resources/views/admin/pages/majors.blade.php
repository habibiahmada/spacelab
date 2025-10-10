<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            {{ __('Data Jurusan') }}
        </h2>
    </x-slot>
  
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
  
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-neskar.neutral-800 dark:text-white">Daftar Jurusan</h3>
                    <p class="text-sm text-neskar.neutral-500 dark:text-neskar.neutral-400">
                        Kelola data seluruh jurusan di sekolah Anda.
                    </p>
                </div>
  
                <a href="#"
                   class="px-4 py-2 bg-neskar.blue-500 hover:bg-neskar.blue-600 text-white rounded-md text-sm transition">
                    <x-heroicon-o-plus class="w-4 h-4 inline-block mr-1" />
                    Tambah Jurusan
                </a>
            </div>
  
            <!-- Search bar -->
            <form method="GET" action="{{ route('admin.majors.index') }}" class="flex items-center justify-end">
                <div class="relative w-full sm:w-64">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / kode / kepala jurusan..."
                        class="w-full rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm px-4 py-2 pr-10 focus:ring-2 focus:ring-neskar.blue-400 focus:outline-none"
                    >
                    <x-heroicon-o-magnifying-glass class="absolute right-3 top-2.5 w-5 h-5 text-slate-400" />
                </div>
            </form>
  
            <!-- Table section -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-neskar.blue-50 dark:bg-slate-700 sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kepala Jurusan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kepala Program</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($majors as $index => $major)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ ($majors->currentPage() - 1) * $majors->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-neskar.blue-700 dark:text-white">{{ $major->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $major->code }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $major->description ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $major->headOfMajor?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $major->programCoordinator?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-end space-x-2">
                                    <a href="#"
                                       class="text-neskar.blue-500 hover:text-neskar.blue-700 transition">
                                        <x-heroicon-o-pencil-square class="w-5 h-5 inline-block" />
                                    </a>
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-neskar.red-500 hover:text-neskar.red-700 transition"
                                                onclick="return confirm('Hapus jurusan ini?')">
                                            <x-heroicon-o-trash class="w-5 h-5 inline-block" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data jurusan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
  
                <!-- Pagination -->
                @if ($majors->hasPages())
                <div class="px-4 py-3 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
                    {{ $majors->links('vendor.pagination.tailwind') }}
                </div>
                @endif
            </div>
  
        </div>
    </div>
  </x-app-layout>
  