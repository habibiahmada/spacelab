<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('staff_id', 32)->unique();
            $table->string('name', 128);
            $table->string('email', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->jsonb('subjects')->nullable();
            $table->jsonb('available_hours')->nullable();
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('teachers');
    }
};
