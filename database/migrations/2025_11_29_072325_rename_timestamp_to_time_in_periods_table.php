<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->renameColumn('start_date', 'start_time');
            $table->renameColumn('end_date', 'end_time');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE periods ALTER COLUMN start_time TYPE time USING start_time::time;");
            DB::statement("ALTER TABLE periods ALTER COLUMN end_time TYPE time USING end_time::time;");
        } else {
            Schema::table('periods', function (Blueprint $table) {
                $table->time('start_time')->change();
                $table->time('end_time')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('periods', function (Blueprint $table) {
            $table->renameColumn('start_time', 'start_date');
            $table->renameColumn('end_time', 'end_date');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE periods ALTER COLUMN start_date TYPE timestamp USING start_date::timestamp;");
            DB::statement("ALTER TABLE periods ALTER COLUMN end_date TYPE timestamp USING end_date::timestamp;");
        } else {
            Schema::table('periods', function (Blueprint $table) {
                $table->timestamp('start_date')->nullable()->change();
                $table->timestamp('end_date')->nullable()->change();
            });
        }
    }
};
