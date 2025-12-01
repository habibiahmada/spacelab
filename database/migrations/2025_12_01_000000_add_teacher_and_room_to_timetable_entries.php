<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            if (! Schema::hasColumn('timetable_entries', 'teacher_id')) {
                $table->uuid('teacher_id')->nullable()->after('teacher_subject_id');
            }

            if (! Schema::hasColumn('timetable_entries', 'room_id')) {
                $table->uuid('room_id')->nullable()->after('room_history_id');
            }

            // create indexes - uniqueness to avoid scheduling conflict per slot
            // we will create index only if database driver supports partials or falls back to normal unique
        });

        // Populate denormalized teacher_id and room_id from relation tables
        // and then make them not null if user wants
        DB::transaction(function () {
            // update teacher_id from teacher_subjects
            DB::table('timetable_entries')->whereNotNull('teacher_subject_id')->chunk(100, function ($entries) {
                foreach ($entries as $entry) {
                    $ts = DB::table('teacher_subjects')->where('id', $entry->teacher_subject_id)->first();
                    if ($ts) {
                        DB::table('timetable_entries')->where('id', $entry->id)->update(['teacher_id' => $ts->teacher_id]);
                    }
                }
            });

            // update room_id from room_history
            DB::table('timetable_entries')->whereNotNull('room_history_id')->chunk(100, function ($entries) {
                foreach ($entries as $entry) {
                    $rh = DB::table('room_history')->where('id', $entry->room_history_id)->first();
                    if ($rh) {
                        DB::table('timetable_entries')->where('id', $entry->id)->update(['room_id' => $rh->room_id]);
                    }
                }
            });

            // add uniqueness constraints (room, day, period) and (teacher, day, period)
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");

            if ($driver === 'pgsql') {
                // create unique index for room slot
                DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS unique_timetable_room_slot ON timetable_entries(room_id, day_of_week, period_id);');
                // create unique index for teacher slot
                DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS unique_timetable_teacher_slot ON timetable_entries(teacher_id, day_of_week, period_id);');
            } else {
                Schema::table('timetable_entries', function (Blueprint $table) {
                    try {
                        $table->unique(['room_id', 'day_of_week', 'period_id'], 'unique_timetable_room_slot');
                    } catch (\Throwable $e) {}

                    try {
                        $table->unique(['teacher_id', 'day_of_week', 'period_id'], 'unique_timetable_teacher_slot');
                    } catch (\Throwable $e) {}
                });
            }

        });
    }

    public function down(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            if (Schema::hasColumn('timetable_entries', 'teacher_id')) {
                try { $table->dropUnique('unique_timetable_teacher_slot'); } catch (\Throwable $e) {}
                try { $table->dropColumn('teacher_id'); } catch (\Throwable $e) {}
            }

            if (Schema::hasColumn('timetable_entries', 'room_id')) {
                try { $table->dropUnique('unique_timetable_room_slot'); } catch (\Throwable $e) {}
                try { $table->dropColumn('room_id'); } catch (\Throwable $e) {}
            }
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS unique_timetable_room_slot;');
            DB::statement('DROP INDEX IF EXISTS unique_timetable_teacher_slot;');
        }
    }
};
