<?php

namespace Aleksa\Locale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom('app/Locale/Database/Migrations');
        include __DIR__ . '/routes.php';
    }
}
