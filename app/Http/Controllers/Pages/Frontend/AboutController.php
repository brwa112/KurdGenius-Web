<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Models\Pages\About\AboutAbout;
use App\Models\Pages\About\AboutMessage;
use App\Models\Pages\About\AboutMission;
use App\Models\Pages\About\AboutTouch;
use App\Models\Pages\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected branch ID from session or use null for all branches
        $branchId = session('selected_branch_id');

        // Fetch about sections for the selected branch
        $about = AboutAbout::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        $message = AboutMessage::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        $mission = AboutMission::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        $touch = AboutTouch::where('is_active', true)
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->first();

        // Fetch gallery items for the selected branch
        // We'll fetch all items and group by category in the frontend
        $galleryItems = Gallery::where('is_active', true)
            ->with('category')
            ->when($branchId, function ($query) use ($branchId) {
                return $query->where('branch_id', $branchId);
            }, function ($query) {
                return $query->whereNull('branch_id');
            })
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'description' => $item->getTranslations('description'),
                    'category' => $item->category_name,
                    'images' => $item->getMedia('images')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->getUrl(),
                            'thumb' => $media->getUrl('thumb'),
                            'medium' => $media->getUrl('medium'),
                        ];
                    })->toArray(),
                ];
            });

        // Group by category for frontend
        $gallery = $galleryItems->groupBy(function ($item) {
            return $item['category']['slug'] ?? 'general';
        })->map(function ($items) {
            return $items->values();
        });

        return inertia('Frontend/Pages/About/Index', [
            'about' => $about ? [
                'description' => $about->getTranslations('description'),
                'images' => $about->getMedia('images')->map(function ($media) {
                    return [
                        'url' => $media->getUrl(),
                        'thumb' => $media->getUrl('thumb'),
                        'medium' => $media->getUrl('medium'),
                    ];
                })->toArray(),
            ] : null,
            'message' => $message ? [
                'description' => $message->getTranslations('description'),
                'author' => $message->getTranslations('author'),
                'author_image' => $message->getFirstMediaUrl('author_image'),
            ] : null,
            'mission' => $mission ? [
                'description' => $mission->getTranslations('description'),
                'images' => $mission->getMedia('images')->map(function ($media) {
                    return [
                        'url' => $media->getUrl(),
                        'thumb' => $media->getUrl('thumb'),
                    ];
                })->toArray(),
            ] : null,
            'touch' => $touch ? [
                'contact_email' => $touch->contact_email,
                'contact_phone' => $touch->contact_phone,
                'contact_address' => $touch->getTranslations('contact_address'),
                'map_iframe' => $touch->map_iframe,
            ] : null,
            'gallery' => $gallery,
        ]);
    }
}
