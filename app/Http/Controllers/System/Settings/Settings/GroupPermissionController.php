<?php

namespace App\Http\Controllers\System\Settings\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\HandlesSorting;
use App\Traits\LogsActivity;
use App\Traits\GenerateSlugKey;
use App\Models\System\Settings\System\GroupPermission;

class GroupPermissionController extends Controller
{
    use LogsActivity, HandlesSorting, GenerateSlugKey;

    public function index(Request $request)
    {
        $this->authorize('viewAny', GroupPermission::class);

        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);

        $GroupPermission = GroupPermission::query()
            ->withCount('permissions')
            ->search($filters['search'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('System/Settings/Settings/GroupPermissions/Index', [
            'group_permissions' => $GroupPermission,
            'filter' => $filters,
        ]);
    }

    private function baseFilter(Request $request): array
    {
        return [
            'start_date' => $request->input('filter.start_date'),
            'end_date' => $request->input('filter.end_date'),
        ];
    }

    public function store(Request $request)
    {
        $this->authorize('create', GroupPermission::class);

        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|string|max:255|unique:layer_one_group_name_permissions,slug',
            'description' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\System\Users\User $user */
        $user = auth()->user();
        $GroupPermission = $user->groupPermissions()->create($validated);

        // Call the function to generate or update the key and translations
        $this->GenerateSlugKey($validated);

        $this->logCreated('Group Name Permission' . $GroupPermission->name, $GroupPermission->id);

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:layer_one_group_name_permissions,name,' . $id,
            'slug' => 'required|string|max:255|unique:layer_one_group_name_permissions,slug,' . $id,
            'description' => 'nullable|string|max:255',

        ]);

        /** @var \App\Models\System\Users\User $user */
        $user = auth()->user();
        $groupPermission = $user->groupPermissions()->findOrFail($id);

        // Call the function to generate or update the key and translations
        $groupPermission->update($validated);

        $this->GenerateSlugKey($validated);

        $this->authorize('update', $groupPermission);

        $this->logUpdated('Group Name Permission' . $groupPermission->name, $groupPermission->id);

        return redirect()->back();
    }


    public function destroy(string $id)
    {
        /** @var \App\Models\System\Users\User $user */
        $user = auth()->user();
        $group_name = $user->groupPermissions()->withCount('permissions')->findOrFail($id);

        $this->authorize('delete', $group_name);

        $this->logDeleted('Group Name Permission' . $group_name->name, $group_name->id);

        $group_name->delete();
        return redirect()->back();
    }
}
