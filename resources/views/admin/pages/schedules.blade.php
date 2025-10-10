<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neskar.blue-700 dark:text-neskar.yellow-400 leading-tight">
            {{ __('Data Jadwal Pelajaran') }}
        </h2>
    </x-slot>
  
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
  
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-neskar.neutral-800 dark:text-white">Daftar Jadwal</h3>
                    <p class="text-sm text-neskar.neutral-500 dark:text-neskar.neutral-400">
                        Kelola data seluruh jadwal pelajaran di sekolah Anda.
                    </p>
                </div>
  
                <a href="#"
                   class="px-4 py-2 bg-neskar.blue-500 hover:bg-neskar.blue-600 text-white rounded-md text-sm">
                    <x-heroicon-o-plus class="w-4 h-4 inline-block mr-1" />
                    Tambah Jadwal
                </a>
            </div>
  
            <!-- Filter section -->
            <form method="GET" class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow-sm flex flex-wrap gap-3 items-center">
                <select name="major" class="border rounded-md p-2 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua Jurusan</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}" {{ request('major') == $major->id ? 'selected' : '' }}>
                            {{ $major->name }}
                        </option>
                    @endforeach
                </select>
  
                <select name="classroom" class="border rounded-md p-2 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua Kelas</option>
                    @foreach($classrooms as $class)
                        <option value="{{ $class->id }}" {{ request('classroom') == $class->id ? 'selected' : '' }}>
                            {{ $class->full_name }}
                        </option>
                    @endforeach
                </select>
  
                <select name="teacher" class="border rounded-md p-2 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua Guru</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
  
                <select name="day" class="border rounded-md p-2 dark:bg-slate-900 dark:text-white">
                    <option value="">Semua Hari</option>
                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $day)
                        <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
  
                <button type="submit" class="bg-neskar.blue-500 hover:bg-neskar.blue-600 text-white px-3 py-2 rounded-md text-sm">
                    Terapkan Filter
                </button>
  
                @if(request()->anyFilled(['major','classroom','teacher','day']))
                    <a href="{{ route('admin.schedules.index') }}"
                       class="text-neskar.red-500 hover:underline text-sm">
                        Reset
                    </a>
                @endif
            </form>
  
            <!-- Table section -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                        <thead class="bg-neskar.blue-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Hari</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Guru</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Kelas</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Ruangan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Waktu</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($schedules as $index => $schedule)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                        {{ $schedules->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                        {{ ucfirst($schedule->day) ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-neskar.blue-700 dark:text-white">
                                        {{ $schedule->subject->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $schedule->teacher->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $schedule->classroom->full_name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $schedule->room->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $schedule->start_at?->format('H:i') ?? '-' }} - {{ $schedule->end_at?->format('H:i') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-end space-x-2">
                                        <a href="#" class="text-neskar.blue-500 hover:text-neskar.blue-700">
                                            <x-heroicon-o-pencil-square class="w-5 h-5 inline-block" />
                                        </a>
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-neskar.red-500 hover:text-neskar.red-700"
                                                    onclick="return confirm('Hapus jadwal ini?')">
                                                <x-heroicon-o-trash class="w-5 h-5 inline-block" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                        Belum ada data jadwal.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
  
                <!-- Pagination -->
                <div class="p-4">
                    {{ $schedules->links() }}
                </div>
            </div>
  
        </div>
    </div>
  </x-app-layout>
  