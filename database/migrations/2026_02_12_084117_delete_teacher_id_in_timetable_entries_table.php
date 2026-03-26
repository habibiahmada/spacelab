<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop unique index/constraint safely using raw SQL
        try {
            $driver = DB::getDriverName();
            if ($driver === 'pgsql') {
                DB::statement('DROP INDEX IF EXISTS unique_timetable_teacher_slot');
            } elseif ($driver === 'mysql') {
                DB::statement('DROP INDEX unique_timetable_teacher_slot ON timetable_entries');
            } elseif ($driver === 'sqlite') {
                // SQLite: Drop index if exists
                DB::statement('DROP INDEX IF EXISTS unique_timetable_teacher_slot');
            }
        } catch (\Throwable $e) {
            // Ignore if index doesn't exist
        }

        Schema::table('timetable_entries', function (Blueprint $table) {
            $table->dropColumn('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('teacher_id')->nullable()->after('subject_id');
        });
    }
};
