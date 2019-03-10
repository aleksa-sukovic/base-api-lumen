<?php

namespace Aleksa\User;

use Illuminate\Support\ServiceProvider;
use Aleksa\User\Database\Factories\UserModelFactory;
use Illuminate\Support\Facades\Gate;
use Aleksa\User\Models\User;
use Aleksa\User\Policies\UserPolicy;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(base_path('app/User/Database/Migrations'));

        if (in_array(app()->environment(), ['local', 'staging', 'testing'])) {
            app(UserModelFactory::class)->register(null);
        }

        Gate::policy(User::class, UserPolicy::class);

        include __DIR__ . '/routes.php';
    }
}
