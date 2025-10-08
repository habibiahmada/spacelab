<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->enum('type', ['jadwal_baru','jadwal_ubah','konflik','info']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->uuid('related_schedule_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('related_schedule_id')->references('id')->on('schedule_entries')->nullOnDelete();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
