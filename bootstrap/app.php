<?php

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

/**
 * Creating Application
 */
$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->withFacades();

$app->withEloquent();

/**
 * Container Bindings
 */
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Aleksa\Library\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Aleksa\Console\Kernel::class
);

/**
 * Aliases
 */
$app->alias('Aleksa\Library\Services\AuthFacadeService', 'Aleksa\Library\Facades\Auth');

/**
 * Global Middlewares
 */
$app->middleware([
    Aleksa\Library\Middlewares\LocaleMiddleware::class,
    Aleksa\Library\Middlewares\CorsMiddleware::class
]);

$app->routeMiddleware([
    'auth' => Aleksa\Auth\Middlewares\Authenticate::class
]);

/**
 * Custom ServiceProviders
 */
$app->register(Aleksa\Locale\LocaleServiceProvider::class);
$app->register(Aleksa\User\UserServiceProvider::class);
$app->register(Aleksa\Auth\AuthServiceProvider::class);
$app->register(Aleksa\UserGroup\UserGroupServiceProvider::class);

return $app;
