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
        Schema::table('temp_student', function (Blueprint $table) {
            $table->enum('action', ['add','edit'])->nullable()->after('medium');
            $table->string('maker_by')->nullable();
            $table->datetime('maker_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temp_student', function (Blueprint $table) {
            //
        });
    }
};
