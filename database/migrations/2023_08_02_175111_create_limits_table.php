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
        Schema::create('limits', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->on('students')->references('id')->onDelete("CASCADE");
            $table->unsignedBigInteger('guardian_id');
            $table->foreign('guardian_id')->on('guardians')->references('id')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limits');
    }
};
