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
        Schema::create('cctv_camera_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')->unique()->constrained('rooms')->onDelete('cascade');
            $table->integer('segment_seconds')->default(300);
            $table->integer('retention_days')->default(30);
            $table->enum('record_mode', ['continuous', 'motion', 'hybrid'])->default('continuous');
            $table->integer('heartbeat_interval_seconds')->default(60);
            $table->integer('max_offline_tolerance_seconds')->default(180);
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_camera_policies');
    }
};
