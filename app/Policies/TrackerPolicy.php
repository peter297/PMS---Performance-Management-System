<?php

namespace App\Policies;

use App\Models\Tracker;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrackerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tracker $tracker): bool
    {
        if($user->isAdmin()){
            return true;
        }

        if($user->isTeacher() && $tracker->user_id === $user->id){
            return true;
        }

        if($user->isCoordinator()){
            return $user->teachers()->where('user.id', $tracker->user_id)->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tracker $tracker): bool
    {
        return $user->isTeacher()
                && $tracker->user_id === $user->id
                && $tracker->status === 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tracker $tracker): bool
    {
        if($user->isAdmin()){
             return true;
        }

        return $user->isTeacher()
            && $tracker->user_id === $user->id
            && $tracker->status === 'pending';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function review(User $user, Tracker $tracker): bool
    {

        if($user->isAdmin()){
            return true;
        }

        if($user->isCoordinator()){
            return $user->teachers()->where('users.id', $tracker->user_id)->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tracker $tracker): bool
    {
        return false;
    }
}
