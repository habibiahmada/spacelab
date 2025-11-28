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
        Schema::table('classes', function (Blueprint $table) {
            if (Schema::hasColumn('classes', 'homeroom_teacher_id')) {
                $table->dropColumn('homeroom_teacher_id');
            }
            if (Schema::hasColumn('classes', 'term_id')) {
                $table->dropColumn('term_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedBigInteger('homeroom_teacher')->nullable()->after('name');
            $table->unsignedBigInteger('term_id')->nullable()->after('homeroom_teacher');
        });
    }
};
