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
        Schema::table('majors', function (Blueprint $table) {
            //
            $table->dropColumn('head_of_major_id');
            $table->dropColumn('program_coordinator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('head_of_major_id')->nullable();
            $table->unsignedBigInteger('program_coordinator_id')->nullable();
        });
    }
};
