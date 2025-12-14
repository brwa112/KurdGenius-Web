<?php

namespace App\Policies;

use App\Models\System\Users\User;
use App\Models\System\Settings\Analytics\Visitor;

class VisitorPolicy
{
    /**
     * Determine whether the user can view any visitors.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view visitors') 
            || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can view the visitor.
     */
    public function view(User $user, Visitor $visitor): bool
    {
        return $user->hasPermissionTo('view visitors') 
            || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can delete the visitor.
     */
    public function delete(User $user, Visitor $visitor): bool
    {
        return $user->hasPermissionTo('delete visitors') 
            || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can delete all visitors.
     */
    public function deleteAll(User $user): bool
    {
        return $user->hasRole(['Super Admin', 'Admin']);
    }
}
