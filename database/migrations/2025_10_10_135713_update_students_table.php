<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('students', function (Blueprint $table) {
            // Hapus kolom 'name' karena nama diambil dari tabel users
            if (Schema::hasColumn('students', 'name')) {
                $table->dropColumn('name');
            }

            // Ubah user_id agar wajib (non-nullable)
            $table->uuid('user_id')->nullable(false)->change();

            // Tambahkan constraint unique agar 1 user hanya bisa jadi 1 siswa
            $table->unique('user_id');

            // Pastikan relasi foreign key tetap terdefinisi dengan cascade delete
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('students', function (Blueprint $table) {
            // Kembalikan kolom 'name'
            $table->string('name', 128)->after('nis');

            // Jadikan user_id nullable kembali
            $table->uuid('user_id')->nullable()->change();

            // Hapus unique constraint
            $table->dropUnique(['user_id']);

            // Ubah foreign key kembali ke nullOnDelete
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};
