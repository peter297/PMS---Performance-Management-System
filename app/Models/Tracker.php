<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TrackerType;

class Tracker extends Model
{
    //

    protected $fillable = ['user_id', 'tracker_type_id', 'file_path', 'original_filename', 'submission_date', 'period_start', 'period_end', 'notes', 'status'];


      protected function casts(): array
    {
        return [
            'submission_date' => 'datetime',
            'period_start' => 'datetime',
            'period_end' => 'datetime',

        ];
    }


    public function trackerTypes(){
      return $this->belongsTo(TrackerType::class, 'tracker_type_id', 'id');
    }
}
