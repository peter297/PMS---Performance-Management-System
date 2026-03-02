<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'name',
        'term_number',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [

 'start_date' => 'date',
 'end_date' => 'date',
 'is_current' => 'boolean',

 ];

//  Relationships

    public function academicYear(){
        return $this->belongsTo(AcademicYear::class);
    }

    public function weeks(){
        return $this->hasMany(Week::class)->orderBy('week_number');
    }

    // Scopes

    public function scopeCurrent($query){
        return $query->where('is_current', true);
    }
}
