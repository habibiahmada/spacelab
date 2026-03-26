<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // Drop the old constraint
            DB::statement('ALTER TABLE attendance_records DROP CONSTRAINT IF EXISTS attendance_records_status_check');

            // Add the new constraint including 'alpa'
            DB::statement("ALTER TABLE attendance_records ADD CONSTRAINT attendance_records_status_check CHECK (status::text = ANY (ARRAY['hadir'::text, 'izin'::text, 'sakit'::text, 'alpa'::text]))");
        }
        // For SQLite and MySQL, constraints are handled differently or not needed for enum-like checks
        // SQLite doesn't support ALTER TABLE DROP CONSTRAINT, and check constraints are less flexible
        // We'll skip this for non-PostgreSQL databases as the status validation can be handled at application level
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE attendance_records DROP CONSTRAINT IF EXISTS attendance_records_status_check');
            DB::statement("ALTER TABLE attendance_records ADD CONSTRAINT attendance_records_status_check CHECK (status::text = ANY (ARRAY['hadir'::text, 'izin'::text, 'sakit'::text]))");
        }
    }
};
