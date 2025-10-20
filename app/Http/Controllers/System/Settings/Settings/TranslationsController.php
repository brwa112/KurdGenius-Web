<?php

namespace App\Http\Controllers\System\Settings\Settings;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\System\Settings\Settings\Key;
use App\Traits\HandlesSorting;
use App\Traits\LogsActivity;
use App\Models\System\Settings\Settings\Translations;

class TranslationsController extends Controller
{
    use LogsActivity, HandlesSorting;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Translations::class);

        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);

        // ToDo: optimize this select()
        $keys = Key::query()->select('id', 'key')->get();

        // ToDo: optimize this select()
        $query = Translations::query()
            ->with('languages', 'keys')
            ->searchByLanguage($filters['languages'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->search($filters['search']);

        $this->applySortingToQuery($query, $filters['sort_by'], $filters['sort_direction'], $this->getSortableFields());

        $translations = $query->paginate($filters['number_rows']);

        return inertia('System/Settings/Settings/Languages/Translations/Index', [
            'keys' => $keys,
            'translations' => $translations,
            'filter' => $filters,
        ]);
    }

    protected function baseFilter(Request $request)
    {
        $filter = $request->query('filter', []);
        return collect([
            'languages' => $filter['languages'] ?? [],
            'start_date' => $request->input('filter.start_date'),
            'end_date' => $request->input('filter.end_date'),
        ]);
    }

    public function getSortableFields(): array
    {
        return [
            'id' => $this->simpleSort('translations.id'),
            'value' => $this->simpleSort('translations.value'),
            'key.key' => $this->relatedSort(
                Key::class,
                'key',
                'id',
                'key_id'
            ),
            'keys.key' => $this->relatedSort(
                Key::class,
                'key',
                'id',
                'key_id'
            ),
        ];
    }

    public function store(Request $request)
    {
        $this->authorize('create', Translations::class);
        // Validate the request data
        $validated = $request->validate([
            'key' => 'required',
            'value' => 'required',
            'languages' => 'required',
        ]);

        $translation =  Translations::create([
            'key_id' => $validated['key']['id'],
            'value' => $validated['value'],
            'language_id' => $validated['languages']['id'], // Assuming languages is an ID
        ]);

        $this->logCreated('Translation ' . $translation->value, $translation->id);

        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $translation = Translations::findOrFail($id);

        $this->authorize('update', $translation);

        $validated = $request->validate([
            'value' => 'required',
        ]);

        $this->logUpdated('Translation ' . $translation->value, $translation->id);

        $translation->update($validated);

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $translation = Translations::findOrFail($id);

        $this->authorize('delete', $translation);

        $this->logDeleted('Translation ' . $translation->value, $translation->id);

        $translation->delete();

        return redirect()->back();
    }
}
