<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MajorSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $allowed = DB::table('subject_major_allowed')
            ->where('is_allowed', true)
            ->get();

        foreach ($allowed as $row) {
            DB::table('major_subject')->updateOrInsert(
                [
                    'major_id' => $row->major_id,
                    'subject_id' => $row->subject_id,
                ],
                [
                    'id' => (string) Str::uuid(), // hapus kalau pivot tidak perlu id
                    'notes' => 'Assigned from subject_major_allowed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ MajorSubjectSeeder populated from allowed mapping.');
    }
}
