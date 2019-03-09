<?php

namespace Aleksa\UserGroup;

use Illuminate\Support\ServiceProvider;
use Aleksa\UserGroup\Database\Factories\UserGroupModelFactory;

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
            app(UserGroupModelFactory::class)->register();
        }

        include __DIR__ . '/routes.php';
    }
}
