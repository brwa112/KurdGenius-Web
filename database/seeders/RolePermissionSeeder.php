<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'users' => [
                'view',
                'create',
                'edit',
                'delete'
            ],
        ];

        foreach ($permissions as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission . '_' . $group,
                    'group' => $group
                ]);
            }
        }

        // Create roles and assign existing permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->syncPermissions(['view_users']);

        // Assign role and permissions to user
        $user = User::first();
        $user->assignRole('admin');
        $user->givePermissionTo(Permission::get()->pluck('name'));

    }
}
