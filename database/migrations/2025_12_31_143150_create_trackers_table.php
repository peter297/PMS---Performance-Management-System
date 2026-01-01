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
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tracker_type_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('original_filename');
            $table->date('submission_date');
            $table->date('period_start');
            $table->date('period_end');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending','reviewed', 'rejected'])->default('pending');
            $table->text('coordinator_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trackers');
    }
};
