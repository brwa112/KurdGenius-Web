<?php

namespace App\Http\Controllers\Pages;

use App\Models\Pages\Campus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampusRequest;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Campus::class);

        $filters = $this->getFilters($request);

        $campuses = Campus::query()->with('user')
            ->search($filters['search'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('Pages/Campus/Index', [
            'campuses' => $campuses,
            'filter' => $filters,
        ]);
    }

    protected function getFilters(Request $request)
    {
        return collect([
            'search' => $request->query('filter')['search'] ?? '',
            'number_rows' => $request->query('filter')['number_rows'] ?? 10,
            'sort_by' => $request->query('filter')['sort_by'] ?? 'id',
            'sort_direction' => $request->query('filter')['sort_direction'] ?? 'desc',
        ]);
    }

    public function store(CampusRequest $request)
    {
        $this->authorize('create', Campus::class);

        $data = $request->validated();

        $campus = Campus::create($data);

        if ($request->hasFile('featured_image')) {
            $campus->clearMediaCollection('featured_image');
            $campus->addMediaFromRequest('featured_image')->preservingOriginal()->toMediaCollection('featured_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $campus->addMedia($image)->preservingOriginal()->toMediaCollection('gallery');
            }
        }
    }

    public function update(CampusRequest $request, Campus $campus)
    {
        $this->authorize('update', $campus);

        $data = $request->validated();

        $campus->update($data);

        if ($request->hasFile('featured_image')) {
            $campus->clearMediaCollection('featured_image');
            $campus->addMediaFromRequest('featured_image')->preservingOriginal()->toMediaCollection('featured_image');
        } elseif ($request->input('remove_featured_image')) {
            $campus->clearMediaCollection('featured_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $campus->addMedia($image)->preservingOriginal()->toMediaCollection('gallery');
            }
        } elseif ($request->input('remove_gallery')) {
            $campus->clearMediaCollection('gallery');
        }
    }

    public function destroy(Campus $campus)
    {
        $this->authorize('delete', $campus);

        $campus->delete();
    }
}

