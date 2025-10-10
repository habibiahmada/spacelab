<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // ============================
            // PELAJARAN UMUM (WAJIB NASIONAL)
            // ============================
            ['code' => 'IND101', 'name' => 'Bahasa Indonesia', 'type' => 'teori', 'description' => 'Pembelajaran bahasa dan sastra Indonesia.'],
            ['code' => 'ING101', 'name' => 'Bahasa Inggris', 'type' => 'teori', 'description' => 'Komunikasi dasar hingga teknis dalam bahasa Inggris.'],
            ['code' => 'MTK101', 'name' => 'Matematika', 'type' => 'teori', 'description' => 'Konsep dasar dan lanjutan matematika SMK.'],
            ['code' => 'PPKN101', 'name' => 'Pendidikan Pancasila dan Kewarganegaraan', 'type' => 'teori', 'description' => 'Pemahaman nilai-nilai Pancasila dan kewarganegaraan.'],
            ['code' => 'AGM101', 'name' => 'Pendidikan Agama', 'type' => 'teori', 'description' => 'Pelajaran agama sesuai keyakinan peserta didik.'],
            ['code' => 'PJOK101', 'name' => 'Pendidikan Jasmani dan Kesehatan', 'type' => 'praktikum', 'description' => 'Kegiatan fisik dan pembinaan kebugaran jasmani.'],
            ['code' => 'SNR101', 'name' => 'Seni Budaya', 'type' => 'teori', 'description' => 'Apresiasi dan ekspresi seni budaya Indonesia.'],
            ['code' => 'INF101', 'name' => 'Informatika Dasar', 'type' => 'teori', 'description' => 'Dasar komputer, logika, dan sistem informasi.'],
            ['code' => 'PKK101', 'name' => 'Proyek Kreatif dan Kewirausahaan', 'type' => 'praktikum', 'description' => 'Penerapan inovasi dan kewirausahaan siswa SMK.'],

            // ============================
            // RPL (Rekayasa Perangkat Lunak)
            // ============================
            ['code' => 'RPL101', 'name' => 'Pemrograman Dasar', 'type' => 'praktikum', 'description' => 'Dasar-dasar logika dan algoritma pemrograman.'],
            ['code' => 'RPL102', 'name' => 'Pemrograman Web', 'type' => 'praktikum', 'description' => 'Membuat aplikasi berbasis web menggunakan HTML, CSS, JS, dan Laravel.'],
            ['code' => 'RPL103', 'name' => 'Pemrograman Berorientasi Objek', 'type' => 'praktikum', 'description' => 'Konsep OOP menggunakan Java atau PHP.'],
            ['code' => 'RPL104', 'name' => 'Basis Data', 'type' => 'teori', 'description' => 'Desain dan implementasi database MySQL dan PostgreSQL.'],
            ['code' => 'RPL105', 'name' => 'Pemrograman Mobile', 'type' => 'praktikum', 'description' => 'Membuat aplikasi Android menggunakan Kotlin/Flutter.'],
            ['code' => 'RPL106', 'name' => 'Analisis dan Perancangan Sistem', 'type' => 'teori', 'description' => 'Menganalisis kebutuhan dan merancang sistem informasi.'],
            ['code' => 'RPL107', 'name' => 'Manajemen Proyek Perangkat Lunak', 'type' => 'teori', 'description' => 'Mengelola pengembangan perangkat lunak dalam tim.'],
            ['code' => 'RPL108', 'name' => 'Cloud Computing dan DevOps', 'type' => 'praktikum', 'description' => 'Dasar penerapan server cloud, deployment, dan CI/CD.'],
            ['code' => 'RPL109', 'name' => 'Keamanan Aplikasi dan Data', 'type' => 'teori', 'description' => 'Menjaga keamanan aplikasi, data, dan privasi pengguna.'],

            // ============================
            // TKJ (Teknik Komputer & Jaringan)
            // ============================
            ['code' => 'TKJ101', 'name' => 'Perakitan Komputer', 'type' => 'praktikum', 'description' => 'Merakit dan memelihara perangkat keras komputer.'],
            ['code' => 'TKJ102', 'name' => 'Jaringan Dasar', 'type' => 'praktikum', 'description' => 'Dasar komunikasi jaringan komputer.'],
            ['code' => 'TKJ103', 'name' => 'Administrasi Jaringan', 'type' => 'praktikum', 'description' => 'Konfigurasi jaringan LAN/WAN menggunakan router dan switch.'],
            ['code' => 'TKJ104', 'name' => 'Sistem Operasi Jaringan', 'type' => 'teori', 'description' => 'Instalasi dan konfigurasi Linux Server dan Windows Server.'],
            ['code' => 'TKJ105', 'name' => 'Jaringan Nirkabel', 'type' => 'praktikum', 'description' => 'Membangun dan mengamankan jaringan wireless.'],
            ['code' => 'TKJ106', 'name' => 'Keamanan Jaringan', 'type' => 'teori', 'description' => 'Konsep keamanan data dan sistem jaringan.'],

            // ============================
            // DKV (Desain Komunikasi Visual)
            // ============================
            ['code' => 'DKV101', 'name' => 'Dasar Desain Grafis', 'type' => 'praktikum', 'description' => 'Pengenalan prinsip desain dan elemen visual.'],
            ['code' => 'DKV102', 'name' => 'Fotografi Digital', 'type' => 'praktikum', 'description' => 'Teknik pengambilan dan pengeditan foto digital.'],
            ['code' => 'DKV103', 'name' => 'Desain Multimedia', 'type' => 'praktikum', 'description' => 'Pembuatan media interaktif dan animasi 2D/3D.'],
            ['code' => 'DKV104', 'name' => 'Tipografi', 'type' => 'teori', 'description' => 'Konsep dan aplikasi tipografi dalam desain.'],
            ['code' => 'DKV105', 'name' => 'Komunikasi Visual', 'type' => 'teori', 'description' => 'Strategi komunikasi melalui elemen visual.'],

            // ============================
            // TKR / TSM (Teknik Kendaraan Ringan / Sepeda Motor)
            // ============================
            ['code' => 'TKR101', 'name' => 'Pemeliharaan Mesin', 'type' => 'praktikum', 'description' => 'Perawatan dan perbaikan mesin kendaraan ringan.'],
            ['code' => 'TKR102', 'name' => 'Chasis dan Suspensi', 'type' => 'praktikum', 'description' => 'Perbaikan sistem kemudi dan suspensi kendaraan.'],
            ['code' => 'TKR103', 'name' => 'Kelistrikan Otomotif', 'type' => 'praktikum', 'description' => 'Analisis dan perbaikan sistem kelistrikan mobil/motor.'],
            ['code' => 'TSM101', 'name' => 'Tune Up Sepeda Motor', 'type' => 'praktikum', 'description' => 'Perawatan dan penyesuaian performa mesin sepeda motor.'],
            ['code' => 'TSM102', 'name' => 'Sistem Bahan Bakar dan Injeksi', 'type' => 'praktikum', 'description' => 'Menangani sistem injeksi modern pada motor.'],

            // ============================
            // AKL (Akuntansi dan Keuangan Lembaga)
            // ============================
            ['code' => 'AKL101', 'name' => 'Akuntansi Dasar', 'type' => 'teori', 'description' => 'Dasar-dasar akuntansi dan pencatatan transaksi.'],
            ['code' => 'AKL102', 'name' => 'Komputer Akuntansi', 'type' => 'praktikum', 'description' => 'Menggunakan aplikasi akuntansi (MYOB, Zahir).'],
            ['code' => 'AKL103', 'name' => 'Perpajakan', 'type' => 'teori', 'description' => 'Pemahaman dasar sistem perpajakan di Indonesia.'],
            ['code' => 'AKL104', 'name' => 'Akuntansi Keuangan', 'type' => 'teori', 'description' => 'Penyusunan laporan keuangan perusahaan jasa dan dagang.'],

            // ============================
            // OTKP (Otomatisasi dan Tata Kelola Perkantoran)
            // ============================
            ['code' => 'OTKP101', 'name' => 'Kearsipan', 'type' => 'praktikum', 'description' => 'Pengelolaan dokumen dan arsip kantor.'],
            ['code' => 'OTKP102', 'name' => 'Layanan Administrasi', 'type' => 'praktikum', 'description' => 'Praktik melayani tamu, surat-menyurat, dan agenda.'],
            ['code' => 'OTKP103', 'name' => 'Teknologi Perkantoran', 'type' => 'teori', 'description' => 'Penggunaan perangkat teknologi dalam kegiatan administrasi.'],
            ['code' => 'OTKP104', 'name' => 'Komunikasi Bisnis', 'type' => 'teori', 'description' => 'Kemampuan berkomunikasi efektif di lingkungan kerja.'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        $this->command->info('✅ SubjectSeeder berhasil menambahkan ' . count($subjects) . ' mata pelajaran.');
    }
}
