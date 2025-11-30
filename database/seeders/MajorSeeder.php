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
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=RPL',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'description' => 'Mempelajari instalasi, konfigurasi, dan administrasi jaringan komputer.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=TKJ',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'description' => 'Fokus pada desain grafis, multimedia, dan komunikasi visual kreatif.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=DKV',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'TSM',
                'name' => 'Teknik dan Bisnis Sepeda Motor',
                'description' => 'Menyiapkan peserta didik untuk menguasai perawatan dan servis sepeda motor.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=TSM',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'TKR',
                'name' => 'Teknik Kendaraan Ringan Otomotif',
                'description' => 'Mempelajari sistem mesin, chasis, dan kelistrikan kendaraan roda empat.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=TKR',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'AKL',
                'name' => 'Akuntansi dan Keuangan Lembaga',
                'description' => 'Fokus pada pencatatan, analisis, dan pelaporan keuangan.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=AKL',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'OTKP',
                'name' => 'Otomatisasi dan Tata Kelola Perkantoran',
                'description' => 'Mengajarkan administrasi, manajemen, dan pelayanan perkantoran modern.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=OTKP',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'BDP',
                'name' => 'Bisnis Daring dan Pemasaran',
                'description' => 'Fokus pada strategi pemasaran digital dan e-commerce.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=BDP',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'TPM',
                'name' => 'Teknik Pemesinan',
                'description' => 'Mempelajari teknik produksi dan pengoperasian mesin industri.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=TPM',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
            ],
            [
                'code' => 'TITL',
                'name' => 'Teknik Instalasi Tenaga Listrik',
                'description' => 'Fokus pada instalasi listrik rumah tangga dan industri.',
                'logo' => 'https://api.dicebear.com/7.x/notionists/svg?seed=TITL',
                'website' => 'https://https://smkn1karawang.sch.id/majors/4/3',
                'slogan' => 'Be Adaptive Creative and Innovative',
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
