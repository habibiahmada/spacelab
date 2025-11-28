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
        //
        Schema::create('blocks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('terms_id');

            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();

            $table->foreign('terms_id')->references('id')->on('terms')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('blocks');
    }
};
