<?php

namespace App\Http\Controllers\Pages;

use App\Models\Pages\Classroom;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRequest;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Classroom::class);

        $filters = $this->getFilters($request);

        $classrooms = Classroom::query()->with('user')
            ->search($filters['search'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        return inertia('Pages/Classrooms/Index', [
            'classrooms' => $classrooms,
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

    public function store(ClassroomRequest $request)
    {
        $this->authorize('create', Classroom::class);

        $data = $request->validated();

        $classroom = Classroom::create($data);

        if ($request->hasFile('featured_image')) {
            $classroom->clearMediaCollection('featured_image');
            $classroom->addMediaFromRequest('featured_image')->preservingOriginal()->toMediaCollection('featured_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $classroom->addMedia($image)->preservingOriginal()->toMediaCollection('gallery');
            }
        }

        if ($request->hasFile('floor_plan')) {
            $classroom->clearMediaCollection('floor_plan');
            $classroom->addMediaFromRequest('floor_plan')->preservingOriginal()->toMediaCollection('floor_plan');
        }
    }

    public function update(ClassroomRequest $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $data = $request->validated();

        $classroom->update($data);

        if ($request->hasFile('featured_image')) {
            $classroom->clearMediaCollection('featured_image');
            $classroom->addMediaFromRequest('featured_image')->preservingOriginal()->toMediaCollection('featured_image');
        } elseif ($request->input('remove_featured_image')) {
            $classroom->clearMediaCollection('featured_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $classroom->addMedia($image)->preservingOriginal()->toMediaCollection('gallery');
            }
        } elseif ($request->input('remove_gallery')) {
            $classroom->clearMediaCollection('gallery');
        }

        if ($request->hasFile('floor_plan')) {
            $classroom->clearMediaCollection('floor_plan');
            $classroom->addMediaFromRequest('floor_plan')->preservingOriginal()->toMediaCollection('floor_plan');
        } elseif ($request->input('remove_floor_plan')) {
            $classroom->clearMediaCollection('floor_plan');
        }
    }

    public function destroy(Classroom $classroom)
    {
        $this->authorize('delete', $classroom);

        $classroom->delete();
    }
}
