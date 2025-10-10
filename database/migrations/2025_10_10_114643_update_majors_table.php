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
        Schema::table('majors', function (Blueprint $table) {
            $table->uuid('head_of_major_id')->nullable()->after('description');
            $table->uuid('program_coordinator_id')->nullable()->after('head_of_major_id');
        
            $table->foreign('head_of_major_id')->references('id')->on('teachers')->nullOnDelete();
            $table->foreign('program_coordinator_id')->references('id')->on('teachers')->nullOnDelete();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('majors', function (Blueprint $table) {
            $table->dropForeign(['head_of_major_id']);
            $table->dropForeign(['program_coordinator_id']);
            $table->dropColumn(['head_of_major_id', 'program_coordinator_id']);            
        });
    }
};
