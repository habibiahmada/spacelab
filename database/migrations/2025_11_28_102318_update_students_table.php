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
        Schema::table('students', function (Blueprint $table) {

            if (!Schema::hasColumn('students', 'name')) {
                $table->string('name')->after('nisn');
            }

            if (Schema::hasColumn('students', 'user_id')) {
                $table->renameColumn('user_id', 'users_id');
            }

            if (!Schema::hasColumn('students', 'avatar')) {
                $table->string('avatar')->nullable()->after('users_id');
            }

            if (Schema::hasColumn('students', 'class_id')) {
                // Drop FK explicitly
                $table->dropForeign(['class_id']);
                $table->dropColumn('class_id');
            }
            if (Schema::hasColumn('students', 'guardian_name')) {
                $table->dropColumn('guardian_name');
            }
            if (Schema::hasColumn('students', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('students', 'avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('students', 'users_id')) {
                $table->renameColumn('users_id', 'user_id');
            }

            if (!Schema::hasColumn('students', 'class_id')) {
                $table->unsignedBigInteger('class_id')->after('nisn');
            }
            if (!Schema::hasColumn('students', 'guardian_name')) {
                $table->string('guardian_name')->after('address');
            }
            if (!Schema::hasColumn('students', 'phone')) {
                $table->string('phone')->after('guardian_name');
            }
        });
    }
};
