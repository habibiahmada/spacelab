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
            // Postgres uses DROP INDEX (or DROP CONSTRAINT if it was a constraint, but here it's an index)
            // MySQL uses DROP INDEX name ON table
            $driver = DB::getDriverName();
            if ($driver === 'pgsql') {
                DB::statement('DROP INDEX IF EXISTS unique_timetable_room_slot');
            } else {
                 // For MySQL/SQLite, generic SQL or Schema builder (but Schema builder might error if not found)
                 // Let's try raw SQL for MySQL too if predictable
                 DB::statement("DROP INDEX unique_timetable_room_slot ON timetable_entries");
            }
        } catch (\Throwable $e) {
            // Ignore if index doesn't exist
        }

        Schema::table('timetable_entries', function (Blueprint $table) {
             // Foreign key likely does not exist based on history.
             // $table->dropForeign(['room_id']);

             $table->dropColumn('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            //
            $table->uuid('room_id')->nullable()->after('teacher_id');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
        });
    }
};
