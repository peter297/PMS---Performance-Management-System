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
        // Teacher to Grade/Stream assignments
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('grade_stream_id')->constrained()->onDelete('cascade');
            $table->foreignId('coordinator_id')->constrained('users')->onDelete('cascade'); // Who assigned
            $table->date('assigned_date');
            $table->date('end_date')->nullable(); // When reassigned
            $table->boolean('is_current')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('teacher_assignments');
    }
};
