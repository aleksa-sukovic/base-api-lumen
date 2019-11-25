<?php

namespace Aleksa\UserGroup;

use Illuminate\Support\ServiceProvider;
use Aleksa\UserGroup\Database\Factories\UserGroupModelFactory;
use Aleksa\UserGroup\Policies\UserGroupPolicy;
use Illuminate\Support\Facades\Gate;
use Aleksa\UserGroup\Models\UserGroup;

class UserGroupServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(base_path('app/UserGroup/Database/Migrations'));

        if (in_array(app()->environment(), ['local', 'staging', 'testing'])) {
            app(UserGroupModelFactory::class)->register(null);
        }

        Gate::policy(UserGroup::class, UserGroupPolicy::class);

        include __DIR__ . '/routes.php';
    }
}
