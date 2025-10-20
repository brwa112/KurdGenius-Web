<?php

namespace App\Policies;

use  App\Models\System\Users\User;

use App\Models\System\Settings\System\UserType;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasDirectPermission('view_usertypes');
    }
    public function view(User $user, UserType $usertype)
    {
        return $user->hasDirectPermission('view_usertypes');
    }

    public function create(User $user)
    {
        return $user->hasDirectPermission('create_usertypes');
    }

    public function update(User $user, UserType $usertype)
    {
        return $user->hasDirectPermission('edit_usertypes');
    }

    public function delete(User $user, UserType $usertype)
    {
        return $user->hasDirectPermission('delete_usertypes');
    }

    public function restore(User $user, UserType $usertype)
    {
        return $user->hasDirectPermission('delete_usertypes');
    }
}
