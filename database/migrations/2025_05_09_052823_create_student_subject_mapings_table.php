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
        Schema::create('student_subject_mapings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();
         
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject_mapings');
    }
};
