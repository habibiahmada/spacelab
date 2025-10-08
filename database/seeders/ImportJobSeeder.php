<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImportJob;
use Illuminate\Support\Str;
use App\Models\User;

class ImportJobSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@ilab.sch.id')->first();

        ImportJob::create([
            'id' => Str::uuid(),
            'type' => 'import',
            'entity' => 'schedule',
            'file_path' => 'storage/imports/schedule.xlsx',
            'status' => 'success',
            'message' => 'Data jadwal berhasil diimpor.',
            'created_by' => $user ? $user->id : null
        ]);
    }
}
