<?php

namespace App\Http\Controllers\System\Settings\Settings;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Traits\HandlesSorting;
use App\Traits\GenerateSlugKey;
use App\Http\Controllers\Controller;
use App\Models\System\Settings\System\UserType;

class UserTypeController extends Controller
{
    use LogsActivity, HandlesSorting, GenerateSlugKey;

    public function index(Request $request)
    {
        $this->authorize('viewAny', UserType::class);

        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);
        $user_type = UserType::query()
            ->search($filters['search'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('System/Settings/Settings/UserTypes/Index', [
            'type' => $user_type,
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

    public function create()
    {
        // return inertia('System/Clients/Packages/Form');
    }


    public function store(Request $request)
    {
        $this->authorize('create', UserType::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:user_types,name,except,id',
            'slug' => 'required|string|max:255|unique:user_types,slug,except,id',
        ]);
        $user_type = UserType::create($validated);

        // Call the function to generate or update the key and translations
        $this->GenerateSlugKey($validated);

        $this->logCreated('User Type' . $user_type->name, $user_type->id);

        return redirect()->back();
    }


    public function show(string $id) {}


    public function edit(string $id) {}


    public function update(Request $request, string $id)
    {

        $user_type = UserType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:user_types,name,' . $id,
            'slug' => 'required|string|max:255|unique:user_types,slug,' . $id,
        ]);

        $this->authorize('update', $user_type);

        $this->logUpdated('User Type' . $user_type->name, $user_type->id);

        // Call the function to generate or update the key and translations
        $this->GenerateSlugKey($validated);

        $user_type->update($validated);

        return redirect()->back();
    }


    public function destroy(string $id)
    {
        $user_type = UserType::findOrFail($id);

        $this->authorize('delete', $user_type);

        $this->authorize('delete', $user_type);

        $this->logDeleted('User Type' . $user_type->name, $user_type->id);

        $user_type->delete();

        return redirect()->back();
    }
}
