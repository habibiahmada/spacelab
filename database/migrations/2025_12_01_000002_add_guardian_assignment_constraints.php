<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // create unique constraint to prevent teacher being guardian for multiple classes at the same time
        Schema::table('guardian_class_history', function (Blueprint $table) {
            if (! Schema::hasColumn('guardian_class_history', 'teacher_id')) {
                return;
            }

            // We will create a unique partial index on teacher_id WHERE ended_at IS NULL to ensure a teacher cannot be guardian of multiple classes simultaneously.
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            // unique partial index for active guardian assignments
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS unique_active_guardian_per_teacher ON guardian_class_history(teacher_id) WHERE ended_at IS NULL;');

            // Add trigger to prevent guardian assignments for teachers who are head_of_major or program_coordinator
            DB::statement(<<<'SQL'
CREATE OR REPLACE FUNCTION check_guardian_not_head_or_pc()
RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM role_assignments WHERE head_of_major_id = NEW.teacher_id OR program_coordinator_id = NEW.teacher_id) THEN
        RAISE EXCEPTION 'Teacher % is a head/program coordinator and cannot be guardian', NEW.teacher_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_check_guardian_role
BEFORE INSERT OR UPDATE ON guardian_class_history
FOR EACH ROW
EXECUTE FUNCTION check_guardian_not_head_or_pc();
SQL
            );
        } else {
            // For other drivers we create unique index without partial support (set ended_at default null); best-effort
            try { Schema::table('guardian_class_history', function (Blueprint $table) { $table->unique(['teacher_id'], 'unique_active_guardian_per_teacher'); }); } catch (\Throwable $e) {}
        }
    }

    public function down(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('DROP TRIGGER IF EXISTS trg_check_guardian_role ON guardian_class_history;');
            DB::statement('DROP FUNCTION IF EXISTS check_guardian_not_head_or_pc();');
            DB::statement('DROP INDEX IF EXISTS unique_active_guardian_per_teacher;');
        } else {
            try { Schema::table('guardian_class_history', function (Blueprint $table) { $table->dropUnique('unique_active_guardian_per_teacher'); }); } catch (\Throwable $e) {}
        }
    }
};
