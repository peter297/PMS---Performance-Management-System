<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_id',
        'week_number',
        'week_name',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    // Relationships

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function classTeacherReports()
    {
        return $this->hasMany(ClassTeacherReport::class);
    }

    // Scopes
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function fullName(): string
    {
        return $this->term->name . ' - ' . $this->week_name;
    }
}
