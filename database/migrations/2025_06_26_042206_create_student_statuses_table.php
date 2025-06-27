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
        Schema::create('student_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('maker_by')->nullable();
            $table->timestamp('maker_at')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected']);

            $table->unsignedBigInteger('approved_by')->nullable(); 
            $table->timestamp('approved_at')->nullable(); 
            $table->timestamps();

      
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('maker_by')->references('id')->on('users')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_statuses');
    }
};
