<?php

namespace Aleksa\Locale;

use Illuminate\Support\ServiceProvider;
use Aleksa\Locale\Database\Factories\LocaleModelFactory;

class LocaleServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom('app/Locale/Database/Migrations');

        if (in_array(app()->environment(), ['local', 'staging', 'testing'])) {
            app(LocaleModelFactory::class)->register();
        }

        include __DIR__ . '/routes.php';
    }
}
