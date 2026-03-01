<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // public function coordinators(){
    //     return $this->belongsToMany(User::class,'teacher_coordinator','teacher_id','coordinator_id')
    //     ->withPivot('assigned_date', 'is_active')
    //     ->withTimestamps();
    // }


    // public function teachers(){
    //     return $this->belongsToMany(User::class,'teacher_coordinator','coordinator_id', 'teacher_id')
    //     ->withPivot('assigned_date', 'is_active')
    //     ->withTimestamps();
    // }


    // public function trackers(){
    //     return $this->hasMany(Tracker::class);
    // }

    // public function reviewedTrackers(){
    //     return $this->hasMany(Tracker::class, 'reviewed_by');
    // }

    // Relationship

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function teacherAssignements(){
        return $this->hasMany(TeacherAssignment::class, 'teacher_id');
    }

    public function currentAssignment(){
        return $this->hasOne(TeacherAssignment::class, 'teacher_id')
            ->where('is_current', true)
            ->latest();
    }

    public function classTeacherReports(){
        return $this->hasMany(ClassTeacherReport::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function isCoordinator(){
        return $this->role === 'coordinator';
    }


    public function isTeacher(){
        return $this->role === 'teacher';
    }

    public function isDeputyHeadTeacher(){
        return $this->role === 'deputy_head_teacher';
    }

    public function isDeputyPrincipal(){
        return $this->role === 'deputy_principal';
    }

    public function isHeadTeacher(){
        return $this->role === 'head_teacher';
    }

    public function isPrincipal(){
        return $this->role === 'principal';
    }

    public function isBranchLevel(){
        return in_array($this->role, ['teacher', 'coordinator', 'deputy_head_teacher', 'deputy_principal']);

    }

    public function isGlobalUser(){
        return in_array($this->role, ['headteacher', 'principal', 'admin']);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
