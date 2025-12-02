<?php

namespace App\Http\Controllers\System\Settings\Settings;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\System\Settings\Settings\Key;
use App\Traits\HandlesSorting;

class KeyLanguageController extends Controller
{
    use HandlesSorting;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Key::class);


        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);

        $keys = Key::query()
            ->search($filters['search'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('System/Settings/Settings/Languages/Keys/Index', [
            'keys' => $keys,
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
        $this->authorize('create', Key::class);

        $validated = $request->validate([
            'key' => 'required|unique:keys,key',
        ]);

        $newKeyId = Key::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'key' => 'required|unique:keys,key',
        ]);

        $key = Key::findOrFail($id);

        $key->update($validated);

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $key = Key::findOrFail($id);

        $key->delete();

        return redirect()->back();
    }
}

