<?php

namespace App\Models\Traits;

trait BranchScopes
{
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('name->en', 'like', "%$search%")
                ->orWhere('name->ckb', 'like', "%$search%")
                ->orWhere('name->ar', 'like', "%$search%")
                ->orWhere('description->en', 'like', "%$search%")
                ->orWhere('description->ckb', 'like', "%$search%")
                ->orWhere('description->ar', 'like', "%$search%")
                ->orWhere('slug', 'like', "%$search%");
        });
    }

    // Filter by creation date range
    public function scopeFilterByDateRange($query, $startDate = null, $endDate = null)
    {
        if (!empty($startDate) && !empty($endDate)) {
            // Both dates provided - filter between the range
            return $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate);
        } elseif (!empty($startDate)) {
            // Only start date provided
            return $query->whereDate('created_at', '>=', $startDate);
        } elseif (!empty($endDate)) {
            // Only end date provided
            return $query->whereDate('created_at', '<=', $endDate);
        }

        return $query;
    }
}
