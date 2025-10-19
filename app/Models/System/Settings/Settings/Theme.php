<?php

namespace App\Models\System\Settings\Settings;

use App\Models\Traits\RangeScopes;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use RangeScopes;
    
    protected $guarded = [];
    
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%")
                     ->orWhere('slug', 'like', "%$search%");
    }
}
