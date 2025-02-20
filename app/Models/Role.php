<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieModel;

class Role extends SpatieModel
{
    protected $fillable = [
        'title',
        'description',
        'name',
        'guard_name',
        'is_hidden',
    ];
}
