<?php

namespace App\Http\Controllers\System\Settings\Settings;

use Inertia\Inertia;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Traits\HandlesSorting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\System\Settings\Settings\Theme;

class ThemeController extends Controller
{
    use LogsActivity, HandlesSorting;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Theme::class);

        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);
        
        $themes = Theme::query()
            ->search($filters['search'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return Inertia::render('System/Settings/Settings/Theme/Index', [
            'themes' => $themes,
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

        $this->authorize('create', Theme::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:themes,name',
            'slug' => 'required|string|max:255|unique:themes,slug',
        ]);

        /** @var \App\Models\System\Users\User $user */
        $user = Auth::user();
        $theme = $user->theme()->create($validated);
        $this->logCreated('Theme ' . $theme->name, $theme->id);
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {

        $theme = Theme::findOrFail($id);
        $this->authorize('update', $theme);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:themes,name,' . $theme->id,
            'slug' => 'required|string|max:255|unique:themes,slug,' . $theme->id,
        ]);

        $this->logUpdated('Theme ' . $theme->name, $theme->id);

        $theme->update($validated);

        return redirect()->back();
    }

    public function destroy(string $id)
    {

        $theme = Theme::findOrFail($id);

        $this->authorize('delete', $theme);

        $this->logDeleted('Theme ' . $theme->name, $theme->id);

        $theme->delete();

        return redirect()->back();
    }
}
