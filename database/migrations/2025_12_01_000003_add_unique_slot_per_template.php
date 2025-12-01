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
            if (! Schema::hasColumn('timetable_entries', 'template_id')) {
                return;
            }
            try {
                $table->unique(['template_id', 'day_of_week', 'period_id'], 'unique_template_slot');
            } catch (\Throwable $e) {}
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS unique_template_slot ON timetable_entries(template_id, day_of_week, period_id);');
        }
    }

    public function down(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            try { $table->dropUnique('unique_template_slot'); } catch (\Throwable $e) {}
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS unique_template_slot;');
        }
    }
};
