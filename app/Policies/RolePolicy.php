<?php

namespace App\Policies;


use  App\Models\System\Users\User;
use App\Models\System\Users\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasDirectPermission('view_roles');
    }
    public function view(User $user, Role $role)
    {
        return $user->hasDirectPermission('view_roles');
    }

    public function create(User $user)
    {
        return $user->hasDirectPermission('create_roles');
    }

    public function update(User $user, Role $role)
    {
        return $user->hasDirectPermission('edit_roles');
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasDirectPermission('delete_roles');
    }

    public function restore(User $user, Role $role)
    {
        return $user->hasDirectPermission('delete_roles');
    }
}
