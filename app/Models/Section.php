<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'display_order',
    ];

    // Relationships

    public function gradeStreams(){
        return $this->hasMany(GradeStream::class)->orderBy('display_order');
    }

    public function subjects(){
        return $this->hasMany(Subject::class);
    }

    public function activeSubjects(){
        return $this->hasMany(Subject::class)->where('is_active', true);
    }
}
