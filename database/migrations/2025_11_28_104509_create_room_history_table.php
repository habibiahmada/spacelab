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
        Schema::create('room_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('room_id');
            $table->string('event_type');
            $table->uuid('classes_id');
            $table->uuid('terms_id');
            $table->uuid('teacher_id');
            $table->uuid('user_id');

            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->foreign('classes_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('terms_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_history');
    }
};