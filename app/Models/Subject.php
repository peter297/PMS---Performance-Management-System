<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
   use HasFactory;

   protected $fillable = [
    'section_id',
    'name',
    'code',
    'is_core',
    'is_active',
   ];

   protected $casts = [
    'is_core' => 'boolean',
    'is_active' => 'boolean',
   ];

   public function section(){
    return $this->belongsTo(Section::class);
   }

   public function syllabusCoverageReports(){
    return $this->hasMany(ReportSyllabusCoverage::class);
   }
}
