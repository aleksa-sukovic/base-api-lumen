<?php

require_once __DIR__.'/../vendor/autoload.php';

Dotenv\Dotenv::create(dirname(__DIR__))->safeLoad();

/**
 * Creating Application
 */
$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
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
 * Extern ServiceProviders
 */
$app->register(Illuminate\Mail\MailServiceProvider::class);

/**
 * Custom ServiceProviders
 */
$app->register(Aleksa\Locale\LocaleServiceProvider::class);
$app->register(Aleksa\User\UserServiceProvider::class);
$app->register(Aleksa\Auth\AuthServiceProvider::class);
$app->register(Aleksa\UserGroup\UserGroupServiceProvider::class);

/**
 * Configuration
 */
$app->configure('services');
$app->configure('mail');

return $app;
