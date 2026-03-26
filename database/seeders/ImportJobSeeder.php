<?php

namespace Database\Seeders;

use App\Models\ImportJob;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImportJobSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();

        ImportJob::create([
            'type' => 'import',
            'entity' => 'schedule',
            'file_path' => 'storage/imports/schedule.xlsx',
            'status' => 'success',
            'message' => 'Data jadwal berhasil diimpor.',
            'created_by' => $user ? $user->id : null,
        ]);
    }
}
