<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('room_id');
            $table->date('date');
            $table->decimal('total_usage_hours', 5, 2)->default(0);
            $table->decimal('total_idle_hours', 5, 2)->default(0);
            $table->decimal('utilization_rate', 5, 2)->default(0);
            $table->timestamp('generated_at');
            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reports');
    }
};