<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Major;

class SubjectMajorAllowedSeeder extends Seeder
{
    public function run(): void
    {
        $mappings = [
            // ===== RPL (Rekayasa Perangkat Lunak) =====
            'RPL101' => ['RPL'],
            'RPL102' => ['RPL'],
            'RPL103' => ['RPL'],
            'RPL104' => ['RPL', 'TKJ', 'AKL'],
            'RPL105' => ['RPL'],
            'RPL106' => ['RPL'],
            'RPL107' => ['RPL'],
            'RPL108' => ['RPL'],
            'RPL109' => ['RPL', 'TKJ'],

            // ===== TKJ (Teknik Komputer & Jaringan) =====
            'TKJ101' => ['TKJ'],
            'TKJ102' => ['TKJ'],
            'TKJ103' => ['TKJ'],
            'TKJ104' => ['TKJ'],
            'TKJ105' => ['TKJ'],
            'TKJ106' => ['TKJ', 'TITL'],

            // ===== DKV (Desain Komunikasi Visual) =====
            'DKV101' => ['DKV'],
            'DKV102' => ['DKV'],
            'DKV103' => ['DKV'],
            'DKV104' => ['DKV'],
            'DKV105' => ['DKV', 'BDP'],

            // ===== TKR (Teknik Kendaraan Ringan Otomotif) =====
            'TKR101' => ['TKR', 'TSM'],
            'TKR102' => ['TKR', 'TSM'],
            'TKR103' => ['TKR', 'TSM'],

            // ===== TSM (Teknik dan Bisnis Sepeda Motor) =====
            'TSM101' => ['TSM'],
            'TSM102' => ['TSM'],

            // ===== AKL (Akuntansi dan Keuangan Lembaga) =====
            'AKL101' => ['AKL', 'OTKP', 'BDP'],
            'AKL102' => ['AKL'],
            'AKL103' => ['AKL', 'OTKP'],
            'AKL104' => ['AKL', 'OTKP'],

            // ===== OTKP (Otomatisasi dan Tata Kelola Perkantoran) =====
            'OTKP101' => ['OTKP', 'AKL'],
            'OTKP102' => ['OTKP'],
            'OTKP103' => ['OTKP', 'RPL'],
            'OTKP104' => ['OTKP', 'AKL', 'BDP'],

            // ===== BDP (Bisnis Daring dan Pemasaran) =====
            'BDP101' => ['BDP'],
            'BDP102' => ['BDP'],
            'BDP103' => ['BDP', 'DKV'],
            'BDP104' => ['BDP'],
            'BDP105' => ['BDP'],

            // ===== TPM (Teknik Pemesinan) =====
            'TPM101' => ['TPM'],
            'TPM102' => ['TPM'],
            'TPM103' => ['TPM'],
            'TPM104' => ['TPM'],
            'TPM105' => ['TPM', 'TITL'],

            // ===== TITL (Teknik Instalasi Tenaga Listrik) =====
            'TITL101' => ['TITL'],
            'TITL102' => ['TITL'],
            'TITL103' => ['TITL'],
            'TITL104' => ['TITL'],
            'TITL105' => ['TITL', 'TPM'],
        ];

        foreach ($mappings as $subjectCode => $majorCodes) {
            $subject = Subject::where('code', $subjectCode)->first();
            if (! $subject) continue;

            foreach ($majorCodes as $majorCode) {
                $major = Major::where('code', $majorCode)->first();
                if (! $major) continue;

                DB::table('subject_major_allowed')->updateOrInsert(
                    [
                        'subject_id' => $subject->id,
                        'major_id' => $major->id,
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'is_allowed' => true,
                        'reason' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info('✅ subject_major_allowed seeded dengan mapping lengkap untuk semua ' . count($mappings) . ' mata pelajaran.');
    }
}
