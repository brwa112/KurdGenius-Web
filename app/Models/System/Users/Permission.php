<?php

namespace App\Models\System\Users;

use App\Models\System\Settings\System\GroupPermission;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'group_permission_id',
    ];

    public function groupPermissions()
    {
        return $this->belongsTo(GroupPermission::class, 'group_permission_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }
}
