<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Pages\Gallery;
use App\Models\System\Settings\Reasons\Log;
use App\Models\System\Settings\Settings\Theme;
use App\Models\System\Users\Permission;
use App\Models\System\Users\User;
use App\Policies\LogsPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ThemesPolicy;
use App\Policies\UserPolicy;
use App\Policies\GalleryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Log::class => LogsPolicy::class,
        Activity::class => LogsPolicy::class, // Add policy for Spatie Activity model
        Theme::class => ThemesPolicy::class,
        Gallery::class => GalleryPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
