<?php

namespace App\Policies;

use App\Models\Pages\Gallery;
use App\Models\System\Users\User;

class GalleryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_gallery');
    }

    public function view(User $user, Gallery $gallery): bool
    {
        return $user->can('view_gallery');
    }

    public function create(User $user): bool
    {
        return $user->can('create_gallery');
    }

    public function update(User $user, Gallery $gallery): bool
    {
        return $user->can('edit_gallery');
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $user->can('delete_gallery');
    }

    public function restore(User $user, Gallery $gallery): bool
    {
        return $user->can('restore_gallery');
    }

    public function forceDelete(User $user, Gallery $gallery): bool
    {
        return $user->can('force_delete_gallery');
    }
}
