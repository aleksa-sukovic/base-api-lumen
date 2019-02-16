<?php

namespace Aleksa\User;

use Illuminate\Support\ServiceProvider;
use Aleksa\User\Database\Factories\UserModelFactory;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom('app/User/Database/Migrations');

        if (in_array(app()->environment(), ['local', 'staging', 'testing'])) {
            app(UserModelFactory::class)->register();
        }

        include __DIR__ . '/routes.php';
    }
}
