<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Major, Teacher};

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        // fetch teachers' users as needed; role assignments will be seeded separately

        $majors = [
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Fokus pada pengembangan perangkat lunak berbasis desktop, web, dan mobile.',
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'description' => 'Mempelajari instalasi, konfigurasi, dan administrasi jaringan komputer.',
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'description' => 'Fokus pada desain grafis, multimedia, dan komunikasi visual kreatif.',
            ],
            [
                'code' => 'TSM',
                'name' => 'Teknik dan Bisnis Sepeda Motor',
                'description' => 'Menyiapkan peserta didik untuk menguasai perawatan dan servis sepeda motor.',
            ],
            [
                'code' => 'TKR',
                'name' => 'Teknik Kendaraan Ringan Otomotif',
                'description' => 'Mempelajari sistem mesin, chasis, dan kelistrikan kendaraan roda empat.',
            ],
            [
                'code' => 'AKL',
                'name' => 'Akuntansi dan Keuangan Lembaga',
                'description' => 'Fokus pada pencatatan, analisis, dan pelaporan keuangan.',
            ],
            [
                'code' => 'OTKP',
                'name' => 'Otomatisasi dan Tata Kelola Perkantoran',
                'description' => 'Mengajarkan administrasi, manajemen, dan pelayanan perkantoran modern.',
            ],
            [
                'code' => 'BDP',
                'name' => 'Bisnis Daring dan Pemasaran',
                'description' => 'Fokus pada strategi pemasaran digital dan e-commerce.',
            ],
            [
                'code' => 'TPM',
                'name' => 'Teknik Pemesinan',
                'description' => 'Mempelajari teknik produksi dan pengoperasian mesin industri.',
            ],
            [
                'code' => 'TITL',
                'name' => 'Teknik Instalasi Tenaga Listrik',
                'description' => 'Fokus pada instalasi listrik rumah tangga dan industri.',
            ],
        ];

        foreach ($majors as $major) {
            Major::updateOrCreate(
                ['code' => $major['code']],
                $major
            );
        }

        $this->command->info('✅ MajorSeeder berhasil menambahkan ' . count($majors) . ' jurusan SMK.');
    }
}
