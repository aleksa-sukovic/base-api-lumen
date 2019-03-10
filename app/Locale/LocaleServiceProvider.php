<?php

namespace Aleksa\Locale;

use Illuminate\Support\ServiceProvider;
use Aleksa\Locale\Database\Factories\LocaleModelFactory;
use Aleksa\Locale\Policies\LocalePolicy;
use Aleksa\Locale\Models\Locale;
use Illuminate\Support\Facades\Gate;

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

        Gate::policy(Locale::class, LocalePolicy::class);

        include __DIR__ . '/routes.php';
    }
}
