<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
    ];

    protected function users(){
        return $this->hasMany(User::class);
    }

    public function teachers(){
        return $this->hasMany(User::class)->where('role', 'teacher');
    }

    public function coordinators(){
        return $this->hasMany(User::class)->where('role', 'coordinator');

    }

    public function deputyHeadTeacher(){

    return $this->hasOne(User::class)->where('role', 'deputy_head_teacher');
    }

    public function deputyPrincipal(){
        return $this->hasOne(User::class)->where('role', 'deputy_principal');
    }

    public function classTeacherReports(){
        return $this->hasMany(ClassTeacherReport::class);
    }

    public function branchHead(){
        if($this->code === 'KIT'){
            return $this->deputyPrincipal();
        }

        return $this->deputyHeadTeacher();
    }
}
