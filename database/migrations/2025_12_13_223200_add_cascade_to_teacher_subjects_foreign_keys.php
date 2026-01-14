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
        Schema::table('teacher_subjects', function (Blueprint $table) {
            // Drop existing foreign keys first. Note: naming might vary, assuming standard naming.
            // Using array syntax to drop by column name often works if DB driver supports it,
            // otherwise explicit name needed. Laravel often names them table_column_foreign.
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['subject_id']);

            $table->foreign('teacher_id')
                ->references('id')->on('teachers')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('id')->on('subjects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['subject_id']);

            $table->foreign('teacher_id')
                ->references('id')->on('teachers'); // Original without cascade

            $table->foreign('subject_id')
                ->references('id')->on('subjects'); // Original without cascade
        });
    }
};
