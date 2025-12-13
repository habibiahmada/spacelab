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
        Schema::table('room_history', function (Blueprint $table) {
            $table->uuid('classes_id')->nullable()->change();
            $table->uuid('teacher_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_history', function (Blueprint $table) {
            $table->uuid('classes_id')->nullable(false)->change();
            $table->uuid('teacher_id')->nullable(false)->change();
        });
    }
};
