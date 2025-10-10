<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Major, Teacher};

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa guru dari database
        // (pastikan TeacherSeeder sudah ada dan dimigrasikan terlebih dahulu)
        $andi = Teacher::where('name', 'Andi Setiawan, S.Kom')->first();
        $budi = Teacher::where('name', 'Budi Santoso, S.T.')->first();
        $citra = Teacher::where('name', 'Citra Lestari, S.Sn')->first();
        $dedi = Teacher::where('name', 'Dedi Haryanto, S.Pd')->first();
        $eka = Teacher::where('name', 'Eka Pratama, S.Ak')->first();
        $fitri = Teacher::where('name', 'Fitri Handayani, S.E.')->first();

        $majors = [
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Fokus pada pengembangan perangkat lunak berbasis desktop, web, dan mobile.',
                'head_of_major_id' => $andi?->id,
                'program_coordinator_id' => $andi?->id,
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer dan Jaringan',
                'description' => 'Mempelajari instalasi, konfigurasi, dan administrasi jaringan komputer.',
                'head_of_major_id' => $budi?->id ?? $andi?->id,
                'program_coordinator_id' => $budi?->id ?? $andi?->id,
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'description' => 'Fokus pada desain grafis, multimedia, dan komunikasi visual kreatif.',
                'head_of_major_id' => $citra?->id,
                'program_coordinator_id' => $citra?->id,
            ],
            [
                'code' => 'TSM',
                'name' => 'Teknik dan Bisnis Sepeda Motor',
                'description' => 'Menyiapkan peserta didik untuk menguasai perawatan dan servis sepeda motor.',
                'head_of_major_id' => $dedi?->id,
                'program_coordinator_id' => $dedi?->id,
            ],
            [
                'code' => 'TKR',
                'name' => 'Teknik Kendaraan Ringan Otomotif',
                'description' => 'Mempelajari sistem mesin, chasis, dan kelistrikan kendaraan roda empat.',
                'head_of_major_id' => $dedi?->id,
                'program_coordinator_id' => $dedi?->id,
            ],
            [
                'code' => 'AKL',
                'name' => 'Akuntansi dan Keuangan Lembaga',
                'description' => 'Fokus pada pencatatan, analisis, dan pelaporan keuangan.',
                'head_of_major_id' => $eka?->id,
                'program_coordinator_id' => $eka?->id,
            ],
            [
                'code' => 'OTKP',
                'name' => 'Otomatisasi dan Tata Kelola Perkantoran',
                'description' => 'Mengajarkan administrasi, manajemen, dan pelayanan perkantoran modern.',
                'head_of_major_id' => $fitri?->id,
                'program_coordinator_id' => $fitri?->id,
            ],
            [
                'code' => 'BDP',
                'name' => 'Bisnis Daring dan Pemasaran',
                'description' => 'Fokus pada strategi pemasaran digital dan e-commerce.',
                'head_of_major_id' => $fitri?->id,
                'program_coordinator_id' => $fitri?->id,
            ],
            [
                'code' => 'TPM',
                'name' => 'Teknik Pemesinan',
                'description' => 'Mempelajari teknik produksi dan pengoperasian mesin industri.',
                'head_of_major_id' => $budi?->id,
                'program_coordinator_id' => $budi?->id,
            ],
            [
                'code' => 'TITL',
                'name' => 'Teknik Instalasi Tenaga Listrik',
                'description' => 'Fokus pada instalasi listrik rumah tangga dan industri.',
                'head_of_major_id' => $dedi?->id,
                'program_coordinator_id' => $dedi?->id,
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
