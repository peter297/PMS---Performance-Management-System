<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TrackerType;

class Tracker extends Model
{
    //

    protected $fillable = ['user_id', 'tracker_type_id', 'file_path', 'original_filename', 'submission_date', 'period_start', 'period_end', 'notes', 'status'];


    public function trackerTypes(){
      return $this->belongsTo(TrackerType::class, 'tracker_type_id', 'id');
    }
}
