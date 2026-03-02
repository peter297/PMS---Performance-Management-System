<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTeacherReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'week_id',
        'grade_stream_id',
        'reporting_date',
        'status',
        'coordinator_id',
        'coordinator_approved_at',
        'coordinator_comments',

    ];

    protected $casts = [
        'reporting_date' => 'date',
        'coordinator_approved_at' => 'datetime',

    ];

    // Relationships

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function week(){
        return $this->belongsTo(Week::class);
    }

    public function gradeStream(){
        return $this->belongsTo(GradeStream::class);
    }

    public function coordinator(){
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    // Reports

    public function attendance(){
        return $this->hasMany(ReportAttendance::class);
    }

    public function attendanceSummary(){
        return $this->hasOne(ReportAttendanceSummary::class);
    }

    public function homework(){
        return $this->hasMany(ReportHomework::class);
    }

    public function homeworkSummary(){
        return $this->hasOne(ReportHomeworkSummary::class);
    }

    public function assessments(){
        return $this->hasMany(ReportAssesment::class);
    }

    public function syllabusCoverage(){
        return $this->hasMany(ReportSyllabusCoverage::class);
    }

    public function assessmentSummary(){
        return $this->hasOne(ReportAssessmentSummary::class);
    }

    public function discipline(){
        return $this->hasMany(ReportDiscipline::class);
    }

    public function disciplineSummary(){
        return $this->hasOne(ReportDisciplineSummary::class);
    }

    public function performanceIndicators(){
        return $this->hasOne(ReportPerformanceIndicator::class);
    }

    public function generalMatters(){
        return  $this->hasOne(ReportGeneralMatter::class);
    }

    // Scopes

    public function scopeDraft($query){
        return $query->where('status', 'draft');
    }

    public function scopeSubmitted($query){
        return $query->where('status', 'submitted');
    }

    public function scopeApproved($query){
        return $query->where('status', 'approved');
    }
    public function scopeRejected($query){
        return $query->where('status', 'rejected');
    }

    // Helper Methods

    public function isDraft(){
        return $this->status === 'draft';
    }

    public function isSubmitted(){
        return $this->status === 'submitted';
    }

    public function isApproved(){
        return $this->status === 'approved';
    }
    public function isRejected(){
        return $this->status === 'rejected';
    }

    public function canEdit(){
        return in_array($this->status, ['draft', 'rejected']);
    }


}
