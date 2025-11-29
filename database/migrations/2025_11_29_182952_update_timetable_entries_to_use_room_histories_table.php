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
            if (Schema::hasColumn('timetable_entries', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn('room_id');
            }

            $table->uuid('room_history_id')->nullable()->after('period_id');

            $table->foreign('room_history_id')
                  ->references('id')
                  ->on('room_history')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('timetable_entries', function (Blueprint $table) {
            if (Schema::hasColumn('timetable_entries', 'room_history_id')) {
                $table->dropForeign(['room_history_id']);
                $table->dropColumn('room_history_id');
            }

            $table->uuid('room_id')->nullable()->after('period_id');
            $table->foreign('room_id')
                  ->references('id')
                  ->on('rooms')
                  ->onDelete('cascade');
        });
    }
};

