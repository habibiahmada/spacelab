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
            'RPL101' => ['RPL'],
            'RPL102' => ['RPL'],
            'RPL104' => ['RPL','AKL'],
            'TKJ101' => ['TKJ'],
            'DKV101' => ['DKV'],
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

        $this->command->info('✅ subject_major_allowed seeded.');
    }
}
