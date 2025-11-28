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
        Schema::table('teachers', function (Blueprint $table) {

            if (!Schema::hasColumn('teachers', 'code')) {
                $table->string('code')->after('id');
            }

            if (!Schema::hasColumn('teachers', 'avatar')) {
                $table->string('avatar')->nullable()->after('user_id');
            }

            foreach (['staff_id', 'name', 'email', 'subjects', 'available_hours', 'image'] as $col) {
                if (Schema::hasColumn('teachers', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'code')) {
                $table->dropColumn('code');
            }
            if (Schema::hasColumn('teachers', 'avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('teachers', 'user')) {
                $table->renameColumn('user', 'user_id');
            }

            if (!Schema::hasColumn('teachers', 'staff_id')) {
                $table->string('staff_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('teachers', 'name')) {
                $table->string('name')->nullable()->after('staff_id');
            }
            if (!Schema::hasColumn('teachers', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
            if (!Schema::hasColumn('teachers', 'subjects')) {
                $table->text('subjects')->nullable()->after('email');
            }
            if (!Schema::hasColumn('teachers', 'available_hours')) {
                $table->string('available_hours')->nullable()->after('subjects');
            }
            if (!Schema::hasColumn('teachers', 'image')) {
                $table->string('image')->nullable()->after('available_hours');
            }
        });
    }
};
