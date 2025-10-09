<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            // Hapus kolom lama
            if (Schema::hasColumn('classes', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('classes', 'academic_year')) {
                $table->dropColumn('academic_year');
            }

            // Tambahkan kolom baru
            $table->string('rombel', 32)->default('1')->after('level');
            $table->uuid('major_id')->nullable()->after('rombel');
            $table->uuid('term_id')->nullable()->after('major_id');
        });

        // Karena PostgreSQL tidak mendukung change(), ubah tipe level manual
        DB::statement('ALTER TABLE classes ALTER COLUMN level TYPE INTEGER USING level::integer;');

        // Tambahkan foreign key setelah kolom dibuat
        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('major_id')->references('id')->on('majors')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Hapus relasi dan kolom baru
        Schema::table('classes', function (Blueprint $table) {
            if (Schema::hasColumn('classes', 'major_id')) {
                $table->dropForeign(['major_id']);
                $table->dropColumn('major_id');
            }
            if (Schema::hasColumn('classes', 'term_id')) {
                $table->dropForeign(['term_id']);
                $table->dropColumn('term_id');
            }
            if (Schema::hasColumn('classes', 'rombel')) {
                $table->dropColumn('rombel');
            }

            // Tambahkan kembali kolom lama
            $table->string('name', 64)->nullable();
            $table->string('academic_year', 16)->nullable();
        });

        // Ubah tipe level kembali ke string jika rollback
        DB::statement('ALTER TABLE classes ALTER COLUMN level TYPE VARCHAR(16) USING level::varchar;');
    }
};
