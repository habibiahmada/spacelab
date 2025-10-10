<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            {{ __('Data Ruangan') }}
        </h2>
    </x-slot>
  
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
  
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-neskar.neutral-800 dark:text-white">Daftar Ruangan</h3>
                    <p class="text-sm text-neskar.neutral-500 dark:text-neskar.neutral-400">
                        Kelola data seluruh ruangan di sekolah Anda.
                    </p>
                </div>
  
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <!-- Form pencarian -->
                    <form method="GET" action="{{ route('admin.rooms.index') }}" class="w-full sm:w-64">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari nama, kode, gedung..."
                                   class="w-full rounded-md border-slate-300 dark:border-slate-700 dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-200 focus:ring-neskar-blue-500 focus:border-neskar-blue-500">
                            <button type="submit"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400">
                                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                            </button>
                        </div>
                    </form>
  
                    <!-- Tombol tambah -->
                    <a href="#"
                       class="px-4 py-2 bg-neskar.blue-500 hover:bg-neskar.blue-600 text-white rounded-md text-sm whitespace-nowrap">
                        <x-heroicon-o-plus class="w-4 h-4 inline-block mr-1" />
                        Tambah Ruangan
                    </a>
                </div>
            </div>
  
            <!-- Table section -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-neskar.blue-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Gedung</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Lantai</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kapasitas</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Perlengkapan</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($rooms as $index => $room)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                    {{ ($rooms->currentPage() - 1) * $rooms->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-neskar.blue-700 dark:text-white">{{ $room->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $room->code }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $room->building }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $room->floor }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $room->capacity }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $room->type }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                  @if(is_array($room->resources))
                                      <div class="flex flex-wrap gap-1">
                                          @foreach($room->resources as $item)
                                              <span class="px-2 py-0.5 text-xs rounded-md bg-neskar-blue-100 dark:bg-slate-700 text-neskar-blue-700 dark:text-slate-200">
                                                  {{ $item }}
                                              </span>
                                          @endforeach
                                      </div>
                                  @else
                                      <span class="text-slate-400">-</span>
                                  @endif
                                </td>
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
                                                onclick="return confirm('Hapus ruangan ini?')">
                                            <x-heroicon-o-trash class="w-5 h-5 inline-block" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data Ruangan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
  
            <!-- Pagination -->
            <div class="px-4">
                {{ $rooms->links() }}
            </div>
  
        </div>
    </div>
  </x-app-layout>
  