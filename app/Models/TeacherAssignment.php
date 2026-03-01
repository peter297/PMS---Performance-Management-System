<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'grade_stream_id',
        'coordinator_id',
        'assigned_date',
        'end_date',
        'is_current',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    // Relationships
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function gradeStream(){
        return $this->belongsTo(GradeStream::class);
    }

    public function coordinator(){
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    // Scope

    public function scopeCurrent($query){
        return $query->where('is_current', true);
    }


}
