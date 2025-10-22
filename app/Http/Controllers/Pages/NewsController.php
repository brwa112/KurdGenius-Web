<?php

namespace App\Http\Controllers\Pages;

use App\Models\Pages\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', News::class);

        $filters = $this->getFilters($request);

        $news = News::query()
            ->with(['user', 'category', 'hashtags'])
            ->search($filters['search'])
            ->orderBy($filters['sort_by'], $filters['sort_direction'])
            ->paginate($filters['number_rows']);

        // Get all categories and hashtags for the dropdowns
        $categories = \App\Models\Pages\Category::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->getTranslations('name'),
                    'slug' => $category->slug,
                ];
            });

        $hashtags = \App\Models\Pages\Hashtag::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($hashtag) {
                return [
                    'id' => $hashtag->id,
                    'name' => $hashtag->getTranslations('name'),
                    'slug' => $hashtag->slug,
                ];
            });

        return inertia('Pages/News/Index', [
            'news' => $news,
            'categories' => $categories,
            'hashtags' => $hashtags,
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

    public function store(NewsRequest $request)
    {
        $this->authorize('create', News::class);

        $data = $request->validated();
        
        // Extract hashtag IDs for many-to-many relationship
        $hashtagIds = $data['hashtag_ids'] ?? [];
        unset($data['hashtag_ids']);

        $news = News::create($data);

        // Sync hashtags (many-to-many)
        $news->hashtags()->sync($hashtagIds);

        // Update hashtag usage counts
        foreach ($hashtagIds as $hashtagId) {
            $hashtag = \App\Models\Pages\Hashtag::find($hashtagId);
            if ($hashtag) {
                $hashtag->incrementUsage();
            }
        }

        // Handle images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $news->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }

        return redirect()->back();
    }

    public function update(NewsRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $data = $request->validated();
        
        // Extract hashtag IDs for many-to-many relationship
        $hashtagIds = $data['hashtag_ids'] ?? [];
        unset($data['hashtag_ids']);

        $news->update($data);

        // Get old hashtag IDs before syncing
        $oldHashtagIds = $news->hashtags->pluck('id')->toArray();

        // Sync hashtags (many-to-many)
        $news->hashtags()->sync($hashtagIds);

        // Update hashtag usage counts
        // Decrement old hashtags that were removed
        $removedHashtagIds = array_diff($oldHashtagIds, $hashtagIds);
        foreach ($removedHashtagIds as $hashtagId) {
            $hashtag = \App\Models\Pages\Hashtag::find($hashtagId);
            if ($hashtag) {
                $hashtag->decrementUsage();
            }
        }

        // Increment new hashtags that were added
        $addedHashtagIds = array_diff($hashtagIds, $oldHashtagIds);
        foreach ($addedHashtagIds as $hashtagId) {
            $hashtag = \App\Models\Pages\Hashtag::find($hashtagId);
            if ($hashtag) {
                $hashtag->incrementUsage();
            }
        }

        // Handle images upload
        if ($request->hasFile('images')) {
            // Clear existing images if remove_images flag is set
            if ($request->input('remove_images')) {
                $news->clearMediaCollection('images');
            }
            
            // Add new images
            foreach ($request->file('images') as $image) {
                $news->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        } elseif ($request->input('remove_images')) {
            // Only clear if no new images are being uploaded
            $news->clearMediaCollection('images');
        }

        return redirect()->back();
    }

    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        $news->delete();

        return redirect()->back();
    }
}
