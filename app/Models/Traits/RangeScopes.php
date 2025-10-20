<?php

namespace App\Models\Traits;

trait RangeScopes
{
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
