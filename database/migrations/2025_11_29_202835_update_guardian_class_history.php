<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if (Schema::hasTable('guardian_class_history') && Schema::hasColumn('guardian_class_history', 'teacher_id')) {
            if ($driver === 'pgsql') {
                DB::statement('ALTER TABLE guardian_class_history DROP CONSTRAINT IF EXISTS guardian_class_history_teacher_id_foreign;');
            }

            try {
                Schema::table('guardian_class_history', function (Blueprint $table) {
                    $table->uuid('teacher_id')->nullable()->change();
                });
            } catch (\Throwable $e) {
                info('Failed to change teacher_id type: '.$e->getMessage());
            }

            if ($driver === 'pgsql') {
                DB::statement('CREATE INDEX IF NOT EXISTS idx_guardian_class_history_teacher_id ON guardian_class_history(teacher_id);');
            } else {
                try {
                    Schema::table('guardian_class_history', function (Blueprint $table) {
                        $table->index('teacher_id');
                    });
                } catch (\Throwable $e) {
                }
            }

            if (Schema::hasTable('teachers')) {
                if ($driver === 'pgsql') {
                    DB::statement('ALTER TABLE guardian_class_history DROP CONSTRAINT IF EXISTS guardian_class_history_teacher_id_foreign;');
                    DB::statement('ALTER TABLE guardian_class_history ADD CONSTRAINT guardian_class_history_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL;');
                } else {
                    try {
                        Schema::table('guardian_class_history', function (Blueprint $table) {
                            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
                        });
                    } catch (\Throwable $e) {
                    }
                }
            }
        }

        if (Schema::hasTable('guardian_class_history')) {
            if (! Schema::hasColumn('guardian_class_history', 'block_id')) {
                Schema::table('guardian_class_history', function (Blueprint $table) {
                    $table->uuid('block_id')->nullable()->after('class_id');
                });
            }

            if (Schema::hasTable('blocks')) {
                if ($driver === 'pgsql') {
                    DB::statement('CREATE INDEX IF NOT EXISTS idx_guardian_class_history_block_id ON guardian_class_history(block_id);');
                    DB::statement('ALTER TABLE guardian_class_history DROP CONSTRAINT IF EXISTS guardian_class_history_block_id_foreign;');
                    DB::statement('ALTER TABLE guardian_class_history ADD CONSTRAINT guardian_class_history_block_id_foreign FOREIGN KEY (block_id) REFERENCES blocks(id) ON DELETE SET NULL;');
                } else {
                    try {
                        Schema::table('guardian_class_history', function (Blueprint $table) {
                            $table->index('block_id');
                            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');
                        });
                    } catch (\Throwable $e) {}
                }
            }
        }

        if ($driver === 'pgsql') {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS guardian_unique_active_per_class ON guardian_class_history(class_id) WHERE ended_at IS NULL;');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('guardian_class_history')) {
            return;
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS guardian_unique_active_per_class;');
            DB::statement('ALTER TABLE guardian_class_history DROP CONSTRAINT IF EXISTS guardian_class_history_teacher_id_foreign;');
            DB::statement('ALTER TABLE guardian_class_history DROP CONSTRAINT IF EXISTS guardian_class_history_block_id_foreign;');
            DB::statement('DROP INDEX IF EXISTS idx_guardian_class_history_teacher_id;');
            DB::statement('DROP INDEX IF EXISTS idx_guardian_class_history_block_id;');
        } else {
            try {
                Schema::table('guardian_class_history', function (Blueprint $table) {
                    $table->dropForeign(['teacher_id']);
                });
            } catch (\Throwable $e) {}

            try {
                Schema::table('guardian_class_history', function (Blueprint $table) {
                    $table->dropForeign(['block_id']);
                });
            } catch (\Throwable $e) {}
            try { Schema::table('guardian_class_history', function (Blueprint $table) { $table->dropIndex(['teacher_id']); }); } catch (\Throwable $e) {}
            try { Schema::table('guardian_class_history', function (Blueprint $table) { $table->dropIndex(['block_id']); }); } catch (\Throwable $e) {}
        }

        Schema::table('guardian_class_history', function (Blueprint $table) {
            if (Schema::hasColumn('guardian_class_history', 'block_id')) {
                try { $table->dropColumn('block_id'); } catch (\Throwable $e) {}
            }
        });
    }
};
