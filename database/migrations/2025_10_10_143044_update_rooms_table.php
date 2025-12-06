<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah constraint enum lama
        // Ubah constraint enum lama
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                ALTER TABLE rooms
                DROP CONSTRAINT IF EXISTS rooms_type_check,
                ADD CONSTRAINT rooms_type_check
                CHECK (type IN (
                    'kelas',
                    'lab',
                    'aula',
                    'kantor',
                    'fasilitas',
                    'penyimpanan',
                    'lainnya'
                ))
            ");
        }
    }

    public function down(): void
    {
        // Balik ke versi sebelumnya
        // Balik ke versi sebelumnya
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                ALTER TABLE rooms
                DROP CONSTRAINT IF EXISTS rooms_type_check,
                ADD CONSTRAINT rooms_type_check
                CHECK (type IN ('kelas', 'lab', 'aula', 'lainnya'))
            ");
        }
    }
};
