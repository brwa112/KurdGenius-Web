<?php

namespace App\Models\Traits;

trait ClassroomScopes
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
                  ->orWhere('classroom_type', 'like', "%$search%")
                  ->orWhere('building', 'like', "%$search%")
                  ->orWhere('room_number', 'like', "%$search%");
        });
    }
}
