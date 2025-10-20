<?php

namespace App\Policies;

use  App\Models\System\Users\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\System\Settings\Settings\FontSize;

class FontSizePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasDirectPermission('view_font_size');
    }
    public function view(User $user, FontSize $fontSize)
    {
        return $user->hasDirectPermission('view_font_size');
    }

    public function create(User $user)
    {
        return $user->hasDirectPermission('create_font_size');
    }

    public function update(User $user, FontSize $fontSize)
    {
        return $user->hasDirectPermission('edit_font_size');
    }

    public function delete(User $user, FontSize $fontSize)
    {
        return $user->hasDirectPermission('delete_font_size');
    }

    public function restore(User $user, FontSize $fontSize)
    {
        return $user->hasDirectPermission('delete_font_size');
    }
}
