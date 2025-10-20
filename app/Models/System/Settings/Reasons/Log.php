<?php

namespace App\Models\System\Settings\Reasons;

use App\Models\System\Users\User;
use App\Models\Traits\RangeScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory, RangeScopes;

    protected $fillable = [
        'action',
        'row_id',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('action', 'like', "%$search%");
    }

    public function scopeFilterByUser($query, $userId = null)
    {
        if (!empty($userId)) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }
}
