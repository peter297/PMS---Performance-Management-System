<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         // Create branches table
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // e.g., 'JR', 'KIT', 'SC'
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Update users table - add branch_id and update roles
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->after('role')->constrained()->nullOnDelete();
        });

        // Update role enum to include all 7 roles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('teacher', 'coordinator', 'deputy_head_teacher', 'deputy_principal', 'head_teacher', 'principal', 'admin') DEFAULT 'teacher'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('teacher', 'coordinator', 'admin') DEFAULT 'teacher'");
        
        Schema::dropIfExists('branches');
    }
};
