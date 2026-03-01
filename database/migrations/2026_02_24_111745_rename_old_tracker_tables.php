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
        // Rename old tables for reference
        Schema::rename('trackers', 'legacy_trackers');
        Schema::rename('tracker_types', 'legacy_tracker_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::rename('legacy_trackers', 'trackers');
        Schema::rename('legacy_tracker_types', 'tracker_types');
    }
};
