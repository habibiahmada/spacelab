<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 64);
            $table->integer('level');
            $table->string('academic_year', 16);
            $table->uuid('homeroom_teacher_id')->nullable();
            $table->timestamps();

            $table->foreign('homeroom_teacher_id')->references('id')->on('teachers')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('classes');
    }
};
