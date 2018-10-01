<?php

namespace Aleksa\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom('app/User/Database/Migrations');
        include __DIR__ . '/routes.php';
    }
}
