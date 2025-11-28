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
        Schema::create('role_assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('major_id');
            $table->uuid('head_of_major_id')->nullable();
            $table->uuid('program_coordinator_id')->nullable();
            $table->uuid('terms_id');

            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->foreign('head_of_major_id')->references('id')->on('teachers')->onDelete('set null');
            $table->foreign('program_coordinator_id')->references('id')->on('teachers')->onDelete('set null');
            $table->foreign('terms_id')->references('id')->on('terms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_assignments');
    }
};
