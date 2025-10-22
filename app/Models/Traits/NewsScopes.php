<?php

namespace App\Models\Traits;

trait NewsScopes
{
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($query) use ($search) {
            $query->where('title->en', 'like', "%$search%")
                  ->orWhere('title->ckb', 'like', "%$search%")
                  ->orWhere('title->ar', 'like', "%$search%")
                  ->orWhere('excerpt->en', 'like', "%$search%")
                  ->orWhere('excerpt->ckb', 'like', "%$search%")
                  ->orWhere('excerpt->ar', 'like', "%$search%")
                  ->orWhere('content->en', 'like', "%$search%")
                  ->orWhere('content->ckb', 'like', "%$search%")
                  ->orWhere('content->ar', 'like', "%$search%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name->en', 'like', "%$search%")
                        ->orWhere('name->ckb', 'like', "%$search%")
                        ->orWhere('name->ar', 'like', "%$search%");
                  })
                  ->orWhereHas('hashtags', function($q) use ($search) {
                      $q->where('name->en', 'like', "%$search%")
                        ->orWhere('name->ckb', 'like', "%$search%")
                        ->orWhere('name->ar', 'like', "%$search%");
                  });
        });
    }
}
