<?php

namespace App\Models\System\Settings\System;


use App\Models\System\Users\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'user_id'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_permission_id', 'id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }
}
