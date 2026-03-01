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
        // Sections (EYE, Upper Primary, Junior School)
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // EYE, Upper Primary, Junior School
            $table->string('code')->unique(); // eye, upper_primary, junior_school
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Grade Streams (1 BLUE, 1 GREEN, etc.)
        Schema::create('grade_streams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->integer('grade_level'); // 1-9
            $table->string('stream_name'); // BLUE, GREEN, RED
            $table->string('full_name'); // "1 BLUE"
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            $table->unique(['grade_level', 'stream_name']);
        });

        // Subjects/Learning Areas
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->boolean('is_core')->default(true); // Core subjects vs optional
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('grade_streams');
        Schema::dropIfExists('sections');
    }
};
