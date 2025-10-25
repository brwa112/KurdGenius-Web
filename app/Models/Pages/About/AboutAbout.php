<?php

namespace App\Models\Pages\About;

use App\Models\System\Users\User;
use App\Traits\LogsMediaActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AboutAbout extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations, LogsActivity, LogsMediaActivity;

    public $translatable = ['title', 'subtitle', 'description', 'founder'];

    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'description',
        'established_year',
        'founder',
        'achievements',
        'metadata',
        'order',
        'is_active',
    ];

    protected $casts = [
        'achievements' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->nonQueued();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'subtitle', 'description', 'established_year', 'founder', 'achievements', 'is_active', 'user_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
