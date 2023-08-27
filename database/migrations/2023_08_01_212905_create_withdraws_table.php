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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0.00);
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->on('students')->references('id')->onDelete("CASCADE");
            $table->unsignedBigInteger('canteen_id')->nullable();
            $table->foreign('canteen_id')->on('canteens')->references('id')->onDelete("CASCADE");
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->on('schools')->references('id')->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
