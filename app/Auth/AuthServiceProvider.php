<?php

namespace Aleksa\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerApiRequestService();

        $this->registerAuthService();
    }

    public function boot()
    {
        include __DIR__ . '/routes.php';
    }

    protected function registerApiRequestService()
    {
        $this->app->bind('Aleksa\Library\Services\ApiRequestService', function () {
            return new \Aleksa\Library\Services\ApiRequestService;
        });
    }

    protected function registerAuthService()
    {
        $this->app->bind('Aleksa\Auth\Services\AuthService', function () {
            return new \Aleksa\Auth\Services\TokenAuthService(
                new \Aleksa\Auth\Managers\TokenManager
            );
        });
    }
}
