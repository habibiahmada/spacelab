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
         Schema::table('rooms', function (Blueprint $table) {

            if (Schema::hasColumn('rooms', 'building')) {
                $table->renameColumn('building', 'building_id');
            }

            if (Schema::hasColumn('rooms', 'type')) {
                $table->dropColumn('type');
            }
            $table->enum('type', ['kelas', 'lab', 'aula', 'lainnya'])->after('capacity');

            if (!Schema::hasColumn('rooms', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('type');
            }

            if (!Schema::hasColumn('rooms', 'notes')) {
                $table->text('notes')->nullable()->after('is_active');
            }

            if (Schema::hasColumn('rooms', 'resources')) {
                $table->dropColumn('resources');
            }

            if (!Schema::hasColumn('rooms', 'created_at') && !Schema::hasColumn('rooms', 'updated_at')) {
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
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'building_id')) {
                $table->renameColumn('building_id', 'building');
            }

            if (Schema::hasColumn('rooms', 'type')) {
                $table->dropColumn('type');
            }
            $table->string('type')->after('capacity');

            if (Schema::hasColumn('rooms', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('rooms', 'notes')) {
                $table->dropColumn('notes');
            }

            if (Schema::hasColumn('rooms', 'created_at') && Schema::hasColumn('rooms', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
