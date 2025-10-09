<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header section -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-neskar.neutral-800 dark:text-white">Daftar Siswa</h3>
                    <p class="text-sm text-neskar.neutral-500 dark:text-neskar.neutral-400">
                        Kelola data seluruh siswa di sekolah Anda.
                    </p>
                </div>

                <a href="#"
                   class="px-4 py-2 bg-neskar.blue-500 hover:bg-neskar.blue-600 text-white rounded-md text-sm">
                    <x-heroicon-o-plus class="w-4 h-4 inline-block mr-1" />
                    Tambah siswa
                </a>
            </div>

            <!-- Table section -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-neskar.blue-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">NIS</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">NISN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kelas</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($students as $index => $student)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-neskar.blue-700 dark:text-white">{{ $student->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $student->nis }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $student->nisn ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $student->classroom?->full_name ?? '-' }}</td>
                                <td class="px-4 py-3 text-end space-x-2">
                                    <a href="#"
                                       class="text-neskar.blue-500 hover:text-neskar.blue-700">
                                        <x-heroicon-o-pencil-square class="w-5 h-5 inline-block" />
                                    </a>
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-neskar.red-500 hover:text-neskar.red-700"
                                                onclick="return confirm('Hapus guru ini?')">
                                            <x-heroicon-o-trash class="w-5 h-5 inline-block" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data guru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
