<?php

namespace App\Http\Controllers\System\Users;

use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Models\System\Users\Permission;
use App\Traits\HandlesSorting;
use App\Http\Requests\LayerTwoPermissionRequest;
use App\Models\System\Settings\System\GroupPermission;


class PermissionController extends Controller
{
    use HandlesSorting;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Permission::class);

        $filters = $this->getFilters($request);

        $query = Permission::query()
            ->with('groupPermissions')
            ->search($filters['search']);

        $this->applySortingToQuery($query, $filters['sort_by'], $filters['sort_direction'], $this->getSortableFields());

        $permissions = $query->paginate($filters['number_rows']);

        $groupPermissions = GroupPermission::query()->select('id', 'name')->get();

        return Inertia::render('System/Users/Permissions/Index', [
            'permissions' => $permissions,
            'groupPermissions' => $groupPermissions,
            'filter' => $filters,
        ]);
    }

    private function getSortableFields(): array
    {
        return [
            // Simple column sorting 
            'id' => $this->simpleSort('permissions.id'),
            'name' => $this->simpleSort('permissions.name'),

            // Related model sorting
            'groupPermissions.name' => $this->relatedSort(
                GroupPermission::class,
                'name',
                'group_permissions.id',
                'group_permissions.layer_one_group_id'
            ),

        ];
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $data = $request->validated();

        $permissionName = PermissionHelper::makePermissionName($data['name'], $data['group_permission_id']);

        $permission = Permission::create([
            'name' => $permissionName,
            'guard_name' => 'web', // Default guard
            'group_permission_id' => $data['group_permission_id'],
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Permission $permission)
    {
        // Todo:: Check if the user has permission to update permissions

        $this->authorize('update', $permission);
        $data = $request->validated();

        $permissionName = PermissionHelper::makePermissionName($data['name'], $data['group_permission_id']);

        $permission->update([
            'name' => $permissionName,
            'group_permission_id' => $data['group_permission_id'],
        ]);

        return redirect()->back();
    }

    public function destroy(Permission $permission)
    {
        // Todo:: Check if the user has permission to delete permissions

        $this->authorize('delete', $permission);

        $permission->delete();

        return redirect()->back();
    }
}

