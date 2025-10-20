<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Pages\Client;
use App\Models\Pages\Hosting;
use App\Models\Pages\Product;
use App\Models\Pages\Service;
use App\Models\System\Settings\Reasons\Log;
use App\Models\System\Settings\Settings\Theme;
use App\Models\System\Users\Permission;
use App\Models\System\Users\User;
use App\Policies\ClientPolicy;
use App\Policies\HostingPolicy;
use App\Policies\LogsPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ServicePolicy;
use App\Policies\ThemesPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Service::class => ServicePolicy::class,
        Product::class => ProductPolicy::class,
        Hosting::class => HostingPolicy::class,
        Client::class => ClientPolicy::class,
        Permission::class => PermissionPolicy::class,
        Log::class => LogsPolicy::class,
        Theme::class => ThemesPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
