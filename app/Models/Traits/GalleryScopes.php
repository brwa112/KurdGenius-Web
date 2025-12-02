<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait GalleryScopes
{
    /**
     * Scope to the gallery collection.
     */
    public function scopeGallery(Builder $query)
    {
        return $query->where('collection_name', 'gallery');
    }

    /**
     * Search file_name or custom_properties JSON payload.
     */
    public function scopeSearch(Builder $query, $term)
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('file_name', 'like', "%{$term}%")
                ->orWhere('custom_properties', 'like', "%{$term}%");
        });
    }

    /**
     * Filter by created_at date range.
     */
    public function scopeDateRange(Builder $query, $start = null, $end = null)
    {
        if ($start) {
            $query->whereDate('created_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('created_at', '<=', $end);
        }
        return $query;
    }

    /**
     * Filter by category stored inside custom_properties->category_id
     */
    public function scopeOfCategory(Builder $query, $categoryId)
    {
        if (empty($categoryId)) return $query;

        return $query->where(function ($q) use ($categoryId) {
            $q->where('custom_properties->category_id', $categoryId)
                ->orWhere('custom_properties', 'like', "%\"category_id\":{$categoryId}%");
        });
    }

    /**
     * Filter by branch stored inside custom_properties->branch_id
     */
    public function scopeOfBranch(Builder $query, $branchId)
    {
        if (empty($branchId)) return $query;

        return $query->where(function ($q) use ($branchId) {
            $q->where('custom_properties->branch_id', $branchId)
                ->orWhere('custom_properties', 'like', "%\"branch_id\":{$branchId}%");
        });
    }
}
