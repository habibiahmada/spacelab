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
        Schema::create('cctv_camera_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')->constrained('rooms')->onDelete('cascade');
            $table->enum('event_type', ['offline', 'online', 'recording_started', 'recording_failed', 'gap_detected', 'manual_bookmark']);
            $table->dateTime('event_at')->index();
            $table->enum('severity', ['info', 'warning', 'critical'])->default('info');
            $table->json('payload')->nullable();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['room_id', 'event_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_camera_events');
    }
};
