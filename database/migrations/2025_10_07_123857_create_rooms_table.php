<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 32)->unique();
            $table->string('name', 128);
            $table->string('building', 64)->nullable();
            $table->integer('floor')->nullable();
            $table->integer('capacity')->nullable();
            $table->enum('type', ['kelas','lab','aula','lainnya']);
            $table->jsonb('resources')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rooms');
    }
};
