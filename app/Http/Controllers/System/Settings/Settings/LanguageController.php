<?php

namespace App\Http\Controllers\System\Settings\Settings;

use Illuminate\Http\Request;
use App\Traits\HandlesSorting;
use App\Traits\GenerateSlugKey;
use Illuminate\Validation\Rule;
use App\Imports\TranslationsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Models\System\Settings\Settings\Key;
use App\Models\System\Settings\Settings\Language;

class LanguageController extends Controller
{
    use HandlesSorting, GenerateSlugKey;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Language::class);

        // Get filters from request
        $filters = $this->getFilters($request);
        $baseFilters = $this->baseFilter($request);
        $filters = $filters->merge($baseFilters);

        $language = Language::query()
            ->search($filters['search'])
            ->filterByDateRange($filters['start_date'], $filters['end_date'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('System/Settings/Settings/Languages/Index', [
            'language' => $language,
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
        $this->authorize('create', Language::class);
        $validated = $request->validate([
            'name' => 'required|unique:languages,name',
            'slug' => 'required|unique:languages,slug',
            'direction' => 'required',
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                function ($attribute, $value, $fail) {
                    $rows = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $value)->first();
                    foreach ($rows as $index => $row) {
                        if (!isset($row[1]) || trim($row[1]) === '') {
                            // Use trans() to pick up the translation
                            $fail(trans('validation.custom.empty_column', ['row' => $index + 1]));
                            break;
                        }
                    }
                }
            ],
        ]);

        $language = Language::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'direction' => $validated['direction']['value'],
        ]);

        // Call the function to generate or update the key and translations
        $this->GenerateSlugKey($validated);

        // Import translations from the uploaded file
        Excel::import(new TranslationsImport($language->id), $request->file('file'));

        return redirect()->back();
    }


    public function update(Request $request, string $id)
    {
        $language = Language::findOrFail($id);
        $this->authorize('update', $language);

        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('languages', 'name')->ignore($language->id),
            ],
            'slug' => [
                'required',
                Rule::unique('languages', 'slug')->ignore($language->id),
            ],
            'direction' => 'required',
            'file' => [
                'nullable',
                'file',
                'mimes:xlsx,xls',
                function ($attribute, $value, $fail) {
                    $rows = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $value)->first();
                    foreach ($rows as $index => $row) {
                        if (!isset($row[1]) || trim($row[1]) === '') {
                            $fail(trans('validation.custom.empty_column', ['row' => $index + 1]));
                            break;
                        }
                    }
                }
            ],
        ]);

        // Call the function to generate or update the key and translations
        $this->GenerateSlugKey($validated);

        $oldLanguageFilename = resource_path('lang/' . $language->name . '.json');
        $newLanguageFilename = resource_path('lang/' . $validated['name'] . '.json');
        // Rename the old language file to the new language file
        if (file_exists($oldLanguageFilename)) {
            rename($oldLanguageFilename, $newLanguageFilename);
        }


        $language->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'direction' => $validated['direction']['value'],
        ]);

        if ($request->hasFile('file')) {
            Excel::import(new TranslationsImport($language->id), $request->file('file'));
        }

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $language = Language::findOrFail($id);

        $this->authorize('delete', $language);

        $languageFilePath = resource_path('lang/' . $language->name . '.json');

        if (file_exists($languageFilePath)) {
            unlink($languageFilePath);
        }

        $language->delete();

        return redirect()->back();
    }
}

