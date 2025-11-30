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
        Schema::create('major_subject', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('major_id');
            $table->uuid('subject_id');
            $table->text('notes')->nullable();

            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['major_id','subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('major_subject');
    }
};
