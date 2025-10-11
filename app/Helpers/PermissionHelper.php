<?php

namespace App\Helpers;

use App\Models\System\Settings\System\GroupPermission;

class PermissionHelper
{
    public static function makePermissionName($name, $groupPermissionId)
    {
        $group = GroupPermission::find($groupPermissionId);
        $permissionName = $name;
        if ($group) {
            $permissionName .= '_' . $group->name;
        }
        return strtolower($permissionName);
    }
}
