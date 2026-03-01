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
       // Academic Years
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "2024/2025"
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        // Terms
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "Term 1", "Term 2", "Term 3"
            $table->integer('term_number'); // 1, 2, 3
            $table->date('start_date'); // Jan, Late April, Late August
            $table->date('end_date'); // Early April, August, End October
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        // Weeks
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('term_id')->constrained()->onDelete('cascade');
            $table->integer('week_number'); // 1-14 (varies by term)
            $table->string('week_name'); // "Week 1", "Week 2", etc.
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weeks');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('academic_years');
    }
};
