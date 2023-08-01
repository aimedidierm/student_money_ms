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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->default(0.00);
            $table->enum('status', ['debit', 'credit']);
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->on('students')->references('id')->onDelete("restrict");
            $table->unsignedBigInteger('canteen_id')->nullable();
            $table->foreign('canteen_id')->on('canteens')->references('id')->onDelete("restrict");
            $table->unsignedBigInteger('guardian_id')->nullable();
            $table->foreign('guardian_id')->on('guardians')->references('id')->onDelete("restrict");
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->on('schools')->references('id')->onDelete("restrict");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
