<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nis', 32)->unique();
            $table->string('nisn', 32)->nullable();
            $table->string('name', 128);
            $table->uuid('class_id');
            $table->string('guardian_name', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('classes')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
