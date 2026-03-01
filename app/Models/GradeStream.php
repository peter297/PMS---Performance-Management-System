<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeStream extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'section_id',
        'grade_level',
        'stream_name',
        'full_name',
        'display_order',
    ];

    // Relationships

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function teacherAssignments(){
        return $this->hasMany(TeacherAssignment::class);
    }

    public function currentTeacher(){
        return $this->hasOne(TeacherAssignment::class)
        ->where('is_current', true)
        ->latest();
    }

    public function classTeacherReports(){
        return $this->hasMany(ClassTeacherReport::class);
    }


}
