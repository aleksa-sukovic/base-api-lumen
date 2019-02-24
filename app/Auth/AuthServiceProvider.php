<?php

namespace Aleksa\Auth;

use Illuminate\Support\ServiceProvider;
use Aleksa\Auth\Services\TokenAuthService;

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
            return app(TokenAuthService::class);
        });
    }
}
