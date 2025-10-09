<x-guest-layout :title="$title" :description="$description">
    <div>
        <!-- HERO -->
        <section class="py-52 px-4 sm:px-6 lg:px-8 bg-neskar-blue-50 dark:bg-slate-900">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="space-y-6">
                    <div class="inline-block px-3 py-1 bg-neskar-yellow-100 text-neskar-yellow-800 rounded-sm text-xs font-medium">
                        Smart School System
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight text-neskar-blue-800 dark:text-white">
                        Digitalisasi Manajemen Sekolah<br>
                        dengan <span class="text-neskar-blue-600">SpaceLab</span>
                    </h1>
                    <p class="text-lg text-neskar-neutral-600 dark:text-neskar-neutral-300 max-w-xl">
                        Platform terpadu untuk mengelola jadwal pelajaran, ruangan, guru, dan siswa secara efisien — 
                        tanpa konflik jadwal dan laporan manual.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mt-6">
                        <a href="/login" class="px-6 py-3 bg-neskar-blue-600 text-white rounded-sm inline-block text-center hover:bg-neskar-blue-700 transition">
                            Masuk Sistem
                        </a>
                        <a href="#features" class="px-6 py-3 border border-neskar-blue-300 dark:border-neskar-blue-700 text-neskar-blue-700 dark:text-white rounded-sm inline-block text-center hover:bg-neskar-blue-100 dark:hover:bg-slate-800 transition">
                            Pelajari Fitur
                        </a>
                    </div>

                    <div class="mt-8 flex space-x-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neskar-green-600">100%</div>
                            <div class="text-sm text-neskar-neutral-500 dark:text-neskar-neutral-400">Terintegrasi</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neskar-blue-600">0</div>
                            <div class="text-sm text-neskar-neutral-500 dark:text-neskar-neutral-400">Konflik Jadwal</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neskar-yellow-600">Realtime</div>
                            <div class="text-sm text-neskar-neutral-500 dark:text-neskar-neutral-400">Monitoring</div>
                        </div>
                    </div>
                </div>

                <!-- Image Preview -->
                <div class="relative">
                    <img src="/assets/images/pages/neskar-ats.webp" 
                        alt="Dashboard Sekolah SpaceLab" 
                        class="rounded-md w-full shadow-md border border-neskar-blue-100 dark:border-slate-700">
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-neskar-blue-800 dark:text-white">Fitur Utama SpaceLab</h2>
                    <p class="text-neskar-neutral-600 dark:text-neskar-neutral-300 mt-2">Didesain khusus untuk efisiensi dan transparansi operasional sekolah</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-6 bg-neskar-blue-50 dark:bg-slate-800 rounded-sm border border-neskar-blue-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-blue-100 dark:bg-neskar-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-calendar class="w-6 h-6 text-neskar-blue-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Manajemen Jadwal</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Atur jadwal pelajaran, ruangan, dan guru dalam satu sistem terpadu. Deteksi otomatis jika terjadi bentrok waktu.
                        </p>
                    </div>

                    <div class="p-6 bg-neskar-yellow-50 dark:bg-slate-800 rounded-sm border border-neskar-yellow-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-yellow-100 dark:bg-neskar-yellow-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-eye class="w-6 h-6 text-neskar-yellow-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Monitoring Ruangan</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Pantau pemakaian ruangan secara langsung, baik melalui check-in manual maupun integrasi sensor IoT.
                        </p>
                    </div>

                    <div class="p-6 bg-neskar-green-50 dark:bg-slate-800 rounded-sm border border-neskar-green-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-chart-bar class="w-6 h-6 text-neskar-green-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Laporan & Analitik</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Lihat statistik penggunaan ruangan, beban mengajar guru, dan laporan aktivitas sekolah dalam format visual interaktif.
                        </p>
                    </div>

                    <div class="p-6 bg-neskar-blue-50 dark:bg-slate-800 rounded-sm border border-neskar-blue-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-blue-100 dark:bg-neskar-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-users class="w-6 h-6 text-neskar-blue-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Manajemen Data Guru & Siswa</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Kelola data guru, staf, dan siswa dengan aman. Dukungan peran dan izin (role-based access).
                        </p>
                    </div>

                    <div class="p-6 bg-neskar-yellow-50 dark:bg-slate-800 rounded-sm border border-neskar-yellow-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-yellow-100 dark:bg-neskar-yellow-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-bell class="w-6 h-6 text-neskar-yellow-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Notifikasi Otomatis</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Dapatkan pemberitahuan langsung jika ada perubahan jadwal, konflik, atau informasi penting lainnya.
                        </p>
                    </div>

                    <div class="p-6 bg-neskar-green-50 dark:bg-slate-800 rounded-sm border border-neskar-green-100 dark:border-slate-700">
                        <div class="w-12 h-12 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-lg flex items-center justify-center mb-4">
                            <x-heroicon-o-lock-closed class="w-6 h-6 text-neskar-green-600" />
                        </div>
                        <h3 class="font-semibold mb-2 text-neskar-blue-800 dark:text-white">Keamanan & Privasi</h3>
                        <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Data sekolah terenkripsi dan terlindungi. Sistem mengikuti standar keamanan modern (CSRF, XSS, hashed password).
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section id="how-it-works" class="py-20 px-4 sm:px-6 lg:px-8 bg-neskar-blue-50 dark:bg-slate-900">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-neskar-blue-800 dark:text-white mb-3">Cara Kerja SpaceLab</h2>
                    <p class="text-neskar-neutral-600 dark:text-neskar-neutral-300">Tiga langkah mudah untuk memulai digitalisasi sekolah Anda</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-neskar-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                            1
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-neskar-blue-800 dark:text-white">Input Data</h3>
                        <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Masukkan data guru, siswa, ruangan, dan mata pelajaran ke dalam sistem. Import data dapat dilakukan secara massal.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-neskar-yellow-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                            2
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-neskar-blue-800 dark:text-white">Atur Jadwal</h3>
                        <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Buat jadwal pelajaran dengan sistem drag-and-drop yang intuitif. Sistem otomatis mendeteksi konflik jadwal.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-neskar-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                            3
                        </div>
                        <h3 class="text-xl font-semibold mb-3 text-neskar-blue-800 dark:text-white">Monitor & Laporan</h3>
                        <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                            Pantau aktivitas sekolah secara realtime dan akses laporan lengkap kapan saja melalui dashboard interaktif.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- BENEFITS -->
        <section id="benefits" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-neskar-blue-800 dark:text-white mb-6">
                            Mengapa Sekolah Memilih SpaceLab?
                        </h2>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="w-6 h-6 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <x-heroicon-o-check class="w-4 h-4 text-neskar-green-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neskar-blue-800 dark:text-white mb-1">Hemat Waktu 70%</h3>
                                    <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                        Otomasi penjadwalan mengurangi waktu kerja administrasi dari berhari-hari menjadi beberapa jam saja.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-6 h-6 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <x-heroicon-o-check class="w-4 h-4 text-neskar-green-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neskar-blue-800 dark:text-white mb-1">Tanpa Konflik Jadwal</h3>
                                    <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                        Sistem deteksi otomatis memastikan tidak ada jadwal yang bentrok antara guru, siswa, atau ruangan.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-6 h-6 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <x-heroicon-o-check class="w-4 h-4 text-neskar-green-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neskar-blue-800 dark:text-white mb-1">Transparansi Penuh</h3>
                                    <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                        Semua stakeholder dapat mengakses informasi yang relevan sesuai dengan peran mereka masing-masing.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-6 h-6 bg-neskar-green-100 dark:bg-neskar-green-900 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <x-heroicon-o-check class="w-4 h-4 text-neskar-green-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-neskar-blue-800 dark:text-white mb-1">Akses Dimana Saja</h3>
                                    <p class="text-sm text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                        Platform berbasis web yang dapat diakses dari desktop, tablet, maupun smartphone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-neskar-blue-100 dark:bg-slate-800 rounded-sm p-8 border border-neskar-blue-200 dark:border-slate-700">
                        <div class="space-y-6">
                            <div class="border-l-4 border-neskar-blue-600 pl-4">
                                <p class="text-neskar-neutral-700 dark:text-neskar-neutral-300 italic mb-2">
                                    "SpaceLab sangat membantu kami dalam mengelola jadwal 45 kelas dan 80 guru. Tidak ada lagi masalah ruangan dobel atau guru mengajar di dua tempat sekaligus."
                                </p>
                                <p class="text-sm font-semibold text-neskar-blue-800 dark:text-white">Drs. Ahmad Wijaya, M.Pd</p>
                                <p class="text-xs text-neskar-neutral-500 dark:text-neskar-neutral-400">Kepala Sekolah SMA Negeri 5 Jakarta</p>
                            </div>

                            <div class="border-l-4 border-neskar-yellow-600 pl-4">
                                <p class="text-neskar-neutral-700 dark:text-neskar-neutral-300 italic mb-2">
                                    "Dengan SpaceLab, kami bisa memantau penggunaan ruangan secara realtime. Efisiensi penggunaan fasilitas meningkat hingga 35%."
                                </p>
                                <p class="text-sm font-semibold text-neskar-blue-800 dark:text-white">Dr. Siti Nurhaliza, S.Pd, M.M</p>
                                <p class="text-xs text-neskar-neutral-500 dark:text-neskar-neutral-400">Wakil Kepala Sekolah SMK Telkom Bandung</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-neskar-blue-600 dark:bg-slate-800">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">150+</div>
                        <div class="text-neskar-blue-100 dark:text-neskar-neutral-300">Sekolah Pengguna</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">5,000+</div>
                        <div class="text-neskar-blue-100 dark:text-neskar-neutral-300">Guru Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">50,000+</div>
                        <div class="text-neskar-blue-100 dark:text-neskar-neutral-300">Siswa Aktif</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-white mb-2">99.9%</div>
                        <div class="text-neskar-blue-100 dark:text-neskar-neutral-300">Uptime System</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faqs" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-slate-950">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-neskar-blue-800 dark:text-white mb-3">Pertanyaan Umum</h2>
                    <p class="text-neskar-neutral-600 dark:text-neskar-neutral-300">Temukan jawaban atas pertanyaan yang sering diajukan</p>
                </div>

                <div class="space-y-4">
                    <div class="border border-neskar-neutral-200 dark:border-slate-700 rounded-sm">
                        <div class="p-5 bg-neskar-blue-50 dark:bg-slate-800">
                            <h3 class="font-semibold text-neskar-blue-800 dark:text-white">Apakah SpaceLab cocok untuk semua jenis sekolah?</h3>
                        </div>
                        <div class="p-5">
                            <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                Ya, SpaceLab dirancang untuk semua jenjang pendidikan mulai dari SD, SMP, SMA, hingga SMK. Sistem dapat disesuaikan dengan kebutuhan spesifik setiap sekolah.
                            </p>
                        </div>
                    </div>

                    <div class="border border-neskar-neutral-200 dark:border-slate-700 rounded-sm">
                        <div class="p-5 bg-neskar-blue-50 dark:bg-slate-800">
                            <h3 class="font-semibold text-neskar-blue-800 dark:text-white">Bagaimana sistem mendeteksi konflik jadwal?</h3>
                        </div>
                        <div class="p-5">
                            <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                Sistem secara otomatis memeriksa ketersediaan guru, ruangan, dan siswa saat jadwal dibuat atau diubah. Jika terdeteksi konflik, sistem akan memberikan peringatan dan saran solusi.
                            </p>
                        </div>
                    </div>

                    <div class="border border-neskar-neutral-200 dark:border-slate-700 rounded-sm">
                        <div class="p-5 bg-neskar-blue-50 dark:bg-slate-800">
                            <h3 class="font-semibold text-neskar-blue-800 dark:text-white">Apakah data sekolah aman di SpaceLab?</h3>
                        </div>
                        <div class="p-5">
                            <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                Sangat aman. Kami menggunakan enkripsi data, autentikasi berlapis, dan backup otomatis. Sistem kami mengikuti standar keamanan industri dan compliance GDPR.
                            </p>
                        </div>
                    </div>

                    <div class="border border-neskar-neutral-200 dark:border-slate-700 rounded-sm">
                        <div class="p-5 bg-neskar-blue-50 dark:bg-slate-800">
                            <h3 class="font-semibold text-neskar-blue-800 dark:text-white">Berapa lama waktu implementasi sistem?</h3>
                        </div>
                        <div class="p-5">
                            <p class="text-neskar-neutral-600 dark:text-neskar-neutral-400">
                                Implementasi awal dapat selesai dalam 1-2 minggu, termasuk migrasi data dan pelatihan pengguna. Tim kami akan mendampingi sekolah hingga sistem berjalan lancar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-16 px-4 sm:px-6 lg:px-8 bg-neskar-blue-600 text-white dark:bg-slate-800 dark:text-white">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-3">Siap Mengoptimalkan Operasional Sekolah Anda?</h2>
                <p class="text-neskar-blue-100 dark:text-neskar-neutral-300 mb-6">Gunakan SpaceLab untuk manajemen jadwal dan fasilitas sekolah yang lebih efisien.</p>
                <a href="/login" class="px-6 py-3 bg-white text-neskar-blue-700 rounded-sm font-semibold hover:bg-neskar-yellow-100 transition inline-block">
                    Bergabung dengan Kami
                </a>
            </div>
        </section>
    </div>
</x-guest-layout>