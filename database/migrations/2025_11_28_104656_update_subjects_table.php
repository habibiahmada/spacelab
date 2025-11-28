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
        Schema::table('subjects', function (Blueprint $table) {

            if (Schema::hasColumn('subjects', 'type')) {
                $table->dropColumn('type');
            }

            $table->enum('type', ['teori', 'praktikum', 'lainnya'])->after('name');

            if (!Schema::hasColumn('subjects', 'created_at') && !Schema::hasColumn('subjects', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'created_at') && Schema::hasColumn('subjects', 'updated_at')) {
                $table->dropTimestamps();
            }

            if (Schema::hasColumn('subjects', 'type')) {
                $table->dropColumn('type');
            }

            $table->string('type')->after('name');
        });
    }
};
