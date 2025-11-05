<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Models\Pages\Client;
use App\Models\Pages\Hosting;
use App\Models\Pages\Product;
use App\Models\Pages\Service;
use App\Models\Pages\Campus;
use App\Models\Pages\Classroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index(Request $request)
    {
        // Get selected branch from request/session
        $selectedBranchId = $request->input('branch_id') ?? session('selected_branch_id');

        // Get campuses filtered by branch
        $campuses = Campus::query()
            ->active()
            ->ofBranch($selectedBranchId)
            ->with(['branch'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($campus) {
                $images = $campus->getMedia('images');
                $firstImage = $images->first();
                
                return [
                    'id' => $campus->id,
                    'slug' => $campus->slug ?? $campus->id,
                    'title' => $campus->getTranslations('title'),
                    'content' => $campus->getTranslations('content'),
                    'imageUrl' => $firstImage ? $firstImage->getUrl('medium') : '/img/campus/1.jpg',
                    'images' => $images->map(fn($media) => [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                        'thumb' => $media->getUrl('thumb'),
                        'medium' => $media->getUrl('medium'),
                    ]),
                    'branch_name' => $campus->branch_name,
                ];
            });

        // Get classrooms filtered by branch
        $classrooms = Classroom::query()
            ->active()
            ->ofBranch($selectedBranchId)
            ->with(['branch'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($classroom) {
                $images = $classroom->getMedia('images');
                $firstImage = $images->first();
                
                return [
                    'id' => $classroom->id,
                    'slug' => $classroom->slug ?? $classroom->id,
                    'title' => $classroom->getTranslations('title'),
                    'content' => $classroom->getTranslations('content'),
                    'imageUrl' => $firstImage ? $firstImage->getUrl('medium') : '/img/class/1.jpg',
                    'images' => $images->map(fn($media) => [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                        'thumb' => $media->getUrl('thumb'),
                        'medium' => $media->getUrl('medium'),
                    ]),
                    'branch_name' => $classroom->branch_name,
                ];
            });

        return inertia('Frontend/Pages/Campus/Index', [
            'campuses' => $campuses,
            'classrooms' => $classrooms,
        ]);
    }

    public function show($slug)
    {
        // Extract ID from slug (format: "title-slug-{id}")
        $id = null;
        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $id = $matches[1];
        }

        // Try to find by ID first, then fallback to direct slug match if needed
        $campus = Campus::query()
            ->active()
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->with(['branch'])
            ->firstOrFail();

        // Increment views
        $campus->incrementViews();

        // Get all images
        $images = $campus->getMedia('images');
        $firstImage = $images->first();

        return inertia('Frontend/Pages/Campus/Show', [
            'detail' => [
                'id' => $campus->id,
                'title' => $campus->getTranslations('title'),
                'description' => $campus->getTranslations('content'),
                'content' => $campus->getTranslations('content'),
                'date' => $campus->created_at->format('Y-m-d'),
                'formatted_date' => $campus->created_at->format('M d, Y'),
                'image' => $firstImage ? $firstImage->getUrl('large') : '/img/campus/1.jpg',
                'images' => $images->map(fn($media) => [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'thumb' => $media->getUrl('thumb'),
                    'medium' => $media->getUrl('medium'),
                    'large' => $media->getUrl('large'),
                ]),
                'branch_name' => $campus->branch_name,
                'views' => $campus->views,
                'hashtag' => null, // Can be added later if needed
            ],
        ]);
    }

    public function showClass($slug)
    {
        // Extract ID from slug (format: "title-slug-{id}")
        $id = null;
        if (preg_match('/-(\d+)$/', $slug, $matches)) {
            $id = $matches[1];
        }

        // Try to find classroom by ID
        $classroom = Classroom::query()
            ->active()
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->with(['branch'])
            ->firstOrFail();

        // Increment views
        $classroom->incrementViews();

        // Get all images
        $images = $classroom->getMedia('images');
        $firstImage = $images->first();

        return inertia('Frontend/Pages/Campus/Show', [
            'detail' => [
                'id' => $classroom->id,
                'title' => $classroom->getTranslations('title'),
                'description' => $classroom->getTranslations('content'),
                'content' => $classroom->getTranslations('content'),
                'date' => $classroom->created_at->format('Y-m-d'),
                'formatted_date' => $classroom->created_at->format('M d, Y'),
                'image' => $firstImage ? $firstImage->getUrl('large') : '/img/class/1.jpg',
                'images' => $images->map(fn($media) => [
                    'id' => $media->id,
                    'url' => $media->getUrl(),
                    'thumb' => $media->getUrl('thumb'),
                    'medium' => $media->getUrl('medium'),
                    'large' => $media->getUrl('large'),
                ]),
                'branch_name' => $classroom->branch_name,
                'views' => $classroom->views,
                'hashtag' => null, // Can be added later if needed
            ],
        ]);
    }
}

