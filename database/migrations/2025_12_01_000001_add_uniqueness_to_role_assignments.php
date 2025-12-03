<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('role_assignments', function (Blueprint $table) {
            if (! Schema::hasColumn('role_assignments', 'head_of_major_id') || ! Schema::hasColumn('role_assignments', 'terms_id')) {
                return;
            }

            // Add simple unique indexes
            try {
                $table->unique(['head_of_major_id', 'terms_id'], 'unique_head_per_term');
            } catch (\Throwable $e) {}

            try {
                $table->unique(['program_coordinator_id', 'terms_id'], 'unique_pc_per_term');
            } catch (\Throwable $e) {}
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            // Create trigger function to prevent teacher assigned as head or pc multiple times
            // Use DB::unprepared or split statements because PG doesn't allow multiple statements in a prepared statement
            DB::unprepared(<<<'SQL'
CREATE OR REPLACE FUNCTION check_role_assignments_once_per_teacher()
RETURNS trigger AS $$
BEGIN
    IF NEW.head_of_major_id IS NOT NULL THEN
        IF EXISTS (SELECT 1 FROM role_assignments WHERE terms_id = NEW.terms_id AND id <> NEW.id AND (head_of_major_id = NEW.head_of_major_id OR program_coordinator_id = NEW.head_of_major_id)) THEN
            RAISE EXCEPTION 'Teacher % already has a role assignment for this term', NEW.head_of_major_id;
        END IF;
    END IF;

    IF NEW.program_coordinator_id IS NOT NULL THEN
        IF EXISTS (SELECT 1 FROM role_assignments WHERE terms_id = NEW.terms_id AND id <> NEW.id AND (head_of_major_id = NEW.program_coordinator_id OR program_coordinator_id = NEW.program_coordinator_id)) THEN
            RAISE EXCEPTION 'Teacher % already has a role assignment for this term', NEW.program_coordinator_id;
        END IF;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
SQL
            );

            DB::statement('CREATE TRIGGER trg_check_role_assignments_once BEFORE INSERT OR UPDATE ON role_assignments FOR EACH ROW EXECUTE FUNCTION check_role_assignments_once_per_teacher();');
        }
    }

    public function down(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('DROP TRIGGER IF EXISTS trg_check_role_assignments_once ON role_assignments;');
            DB::statement('DROP FUNCTION IF EXISTS check_role_assignments_once_per_teacher();');
        }

        Schema::table('role_assignments', function (Blueprint $table) {
            try { $table->dropUnique('unique_head_per_term'); } catch (\Throwable $e) {}
            try { $table->dropUnique('unique_pc_per_term'); } catch (\Throwable $e) {}
        });
    }
};
