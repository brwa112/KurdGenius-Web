<?php

namespace App\Models\Pages\Calendar;

use App\Models\Pages\Branch;
use App\Models\System\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class CalendarOfficial extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, LogsActivity;

    protected $fillable = [
        'user_id',
        'branch_id',
        'description',
        'holidays',
        'is_active',
    ];

    public $translatable = ['description', 'holidays'];

    protected $casts = [
        'is_active' => 'boolean',
        'holidays' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['description', 'holidays', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Calendar Official {$eventName}");
    }
}
