<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('schedule_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('room_id');
            $table->uuid('class_id');
            $table->uuid('teacher_id');
            $table->uuid('subject_id');
            $table->uuid('term_id');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->text('recurrence_rule')->nullable();
            $table->enum('status', ['confirmed','pending','cancelled'])->default('pending');
            $table->text('note')->nullable();
            $table->uuid('created_by')->nullable();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['room_id', 'start_at']);
            $table->index(['teacher_id', 'start_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('schedule_entries');
    }
};