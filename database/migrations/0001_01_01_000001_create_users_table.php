<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 128);
            $table->string('email', 128)->unique();
            // Laravel expects an email_verified_at timestamp for email verification support
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password_hash');
            // Remember token for session "remember me"
            $table->rememberToken();
            $table->uuid('role_id');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
