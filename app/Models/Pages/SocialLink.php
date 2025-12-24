<?php

namespace App\Models\Pages;

use Spatie\Activitylog\LogOptions;
use App\Models\Traits\ServiceScopes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
    use HasFactory, LogsActivity, ServiceScopes;

    protected $fillable = [
        'facebook',
        'instagram',
        'telegram',
        'whatsapp',
        'email',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['facebook', 'instagram', 'telegram', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "SocialLink {$eventName}");
    }
}
