<?php

namespace Database\Seeders;

use App\Models\System\Settings\System\GroupPermission;
use  App\Models\System\Users\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $groupPermissions = GroupPermission::all();

        $allPermissionNames = [];
        $userPermissionNames = [];
        foreach ($groupPermissions as $group) {
            foreach (['view', 'create', 'edit', 'delete', 'restore'] as $action) {
                $permName = $action . '_' . $group->name;
                Permission::firstOrCreate([
                    'name' => $permName,
                    'group_permission_id' => $group->id
                ]);
                $allPermissionNames[] = $permName;
                if ($action === 'view') {
                    $userPermissionNames[] = $permName;
                }
            }
        }

        // Get or create a system user for seeding
        $systemUser = User::first();

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
        );
        $adminRole->syncPermissions($allPermissionNames);

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
        );
        $userRole->syncPermissions($userPermissionNames);

        $this->createSuperAdmin();
        $this->createDeveloper();
    }

    private function createSuperAdmin()
    {
        $groupPermissions = GroupPermission::whereNotIn('name', ['permissions', 'layer_one_group_name_permissions', 'group_permissions'])->get();

        $allPermissionNames = [];

        foreach ($groupPermissions as $group) {
            foreach (['view', 'create', 'edit', 'delete', 'restore'] as $action) {
                $permName = $action . '_' . $group->name;
                Permission::firstOrCreate([
                    'name' => $permName,
                    'group_permission_id' => $group->id
                ]);
                $allPermissionNames[] = $permName;
            }
        }

        // Get the first user
        $user = User::first();

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
        );

        $adminRole->syncPermissions($allPermissionNames);

        // Assign role and permissions to user
        if ($user) {
            $user->assignRole($adminRole);
            $user->givePermissionTo($allPermissionNames);
        }
    }

    private function createDeveloper()
    {
        $groupPermissions = GroupPermission::whereIn('name', ['users', 'roles', 'permissions', 'group_permissions'])->get();

        $allPermissionNames = [];

        foreach ($groupPermissions as $group) {
            foreach (['view', 'create', 'edit', 'delete', 'restore'] as $action) {
                $permName = $action . '_' . $group->name;
                Permission::firstOrCreate([
                    'name' => $permName,
                    'group_permission_id' => $group->id
                ]);
                $allPermissionNames[] = $permName;
            }
        }

        // Get the developer user
        $user = User::where('email', 'developer@safedatait.com')->first();

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(
            ['name' => 'developer'],
        );

        $adminRole->syncPermissions($allPermissionNames);

        // Assign role and permissions to user
        if ($user) {
            $user->assignRole($adminRole);
            $user->givePermissionTo($allPermissionNames);
        }
    }
}
