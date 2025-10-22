<?php

namespace App\Models\Traits;

trait CampusScopes
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
                  ->orWhere('location->en', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        });
    }
}
