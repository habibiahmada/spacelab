<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // URL stream kamera (untuk IP Camera / DroidCam)
            $table->string('stream_url')->nullable()->after('notes');
            // Tipe kamera: 'none' | 'webcam' | 'ip_camera'
            $table->enum('camera_type', ['none', 'webcam', 'ip_camera'])->default('none')->after('stream_url');
            // Apakah kamera aktif ditampilkan di grid CCTV
            $table->boolean('is_camera_active')->default(true)->after('camera_type');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['stream_url', 'camera_type', 'is_camera_active']);
        });
    }
};