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
        Schema::create('company_relations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('company_id');
            $table->uuid('major_id'); 

            $table->string('partnership_type')->nullable(); // Contoh: 'internship', 'recruitment', 'mou'
            $table->string('status')->default('active'); // Contoh: 'active', 'expired', 'pending'
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('document_link')->nullable();


            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_relations');
    }
};
