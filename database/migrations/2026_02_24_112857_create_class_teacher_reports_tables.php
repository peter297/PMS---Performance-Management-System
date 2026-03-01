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
        // Main Class Teacher Report
        Schema::create('class_teacher_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Teacher
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('week_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_stream_id')->constrained()->onDelete('cascade');
            $table->date('reporting_date');
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            
            // Approval by Coordinator
            $table->foreignId('coordinator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('coordinator_approved_at')->nullable();
            $table->text('coordinator_comments')->nullable();
            
            $table->timestamps();
            
            // One report per teacher per week
            $table->unique(['user_id', 'week_id']);
        });

        // 1. Attendance Section
        Schema::create('report_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->integer('learners_present')->default(0);
            $table->integer('learners_absent')->default(0);
            $table->decimal('attendance_percentage', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('report_attendance_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->decimal('weekly_average_attendance', 5, 2)->default(0);
            $table->text('comment_intervention')->nullable();
            $table->timestamps();
        });

        // 2. Homework & Class Projects Section
        Schema::create('report_homework', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->integer('homework_done')->default(0);
            $table->integer('homework_not_done')->default(0);
            $table->text('teacher_followup')->nullable();
            $table->timestamps();
        });

        Schema::create('report_homework_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->decimal('compliance_percentage', 5, 2)->default(0);
            $table->text('general_comment')->nullable();
            $table->timestamps();
        });

        // 3. Assessments & Syllabus Coverage Section
        Schema::create('report_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->date('assessment_date');
            $table->string('learning_area');
            $table->enum('type', ['Formative', 'Summative']);
            $table->timestamps();
        });

        Schema::create('report_syllabus_coverage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('teacher_name');
            $table->decimal('percentage_covered', 5, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('report_assessment_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->integer('total_assessments')->default(0);
            $table->decimal('average_coverage', 5, 2)->default(0);
            $table->text('areas_requiring_intervention')->nullable();
            $table->timestamps();
        });

        // 4. Classroom Management & Discipline Section
        Schema::create('report_discipline', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->text('issue_incident')->nullable();
            $table->text('persons_involved')->nullable();
            $table->text('action_taken')->nullable();
            $table->timestamps();
        });

        Schema::create('report_discipline_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->decimal('issues_resolved_percentage', 5, 2)->nullable();
            $table->text('general_comment')->nullable();
            $table->timestamps();
        });

        // 5. Teacher Performance Indicators Section
        Schema::create('report_performance_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->boolean('lesson_preparation_documentation')->default(false);
            $table->decimal('ict_integration_percentage', 5, 2)->nullable();
            $table->decimal('iep_compliance_percentage', 5, 2)->nullable();
            $table->decimal('teacher_attendance_percentage', 5, 2)->nullable();
            $table->boolean('action_points_implemented')->default(false);
            $table->text('parental_engagement_activities')->nullable();
            $table->timestamps();
        });

        // 6. General Matters Section
        Schema::create('report_general_matters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_teacher_report_id')->constrained()->onDelete('cascade');
            $table->text('matters_requiring_action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('report_general_matters');
        Schema::dropIfExists('report_performance_indicators');
        Schema::dropIfExists('report_discipline_summary');
        Schema::dropIfExists('report_discipline');
        Schema::dropIfExists('report_assessment_summary');
        Schema::dropIfExists('report_syllabus_coverage');
        Schema::dropIfExists('report_assessments');
        Schema::dropIfExists('report_homework_summary');
        Schema::dropIfExists('report_homework');
        Schema::dropIfExists('report_attendance_summary');
        Schema::dropIfExists('report_attendance');
        Schema::dropIfExists('class_teacher_reports');
    }
};
