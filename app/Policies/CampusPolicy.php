<?php

namespace App\Policies;

use App\Models\Pages\Campus;
use App\Models\System\Users\User;

class CampusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_campus');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campus $campus): bool
    {
        return $user->can('view_campus');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_campus');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campus $campus): bool
    {
        return $user->can('edit_campus');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campus $campus): bool
    {
        return $user->can('delete_campus');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campus $campus): bool
    {
        return $user->can('restore_campus');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campus $campus): bool
    {
        return $user->can('force_delete_campus');
    }
}
