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
        Schema::create('cctv_recording_segments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('room_id')->constrained('rooms')->onDelete('cascade');
            $table->enum('camera_type', ['webcam', 'ip_camera']);
            $table->enum('record_mode', ['continuous', 'motion', 'hybrid'])->default('continuous');
            $table->dateTime('segment_start_at')->index();
            $table->dateTime('segment_end_at')->index();
            $table->integer('duration_seconds');
            $table->string('file_path');
            $table->bigInteger('file_size_bytes')->nullable();
            $table->string('codec')->nullable();
            $table->string('resolution')->nullable();
            $table->boolean('has_motion')->default(false);
            $table->enum('integrity_status', ['ok', 'missing', 'corrupt'])->default('ok');
            $table->timestamps();
            
            $table->index(['room_id', 'segment_start_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cctv_recording_segments');
    }
};
