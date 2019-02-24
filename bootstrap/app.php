<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

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
$app->alias('Aleksa\Library\Services\ApiRequestService', 'Aleksa\Library\Facades\ApiRequest');

/**
 * Global Middlewares
 */
$app->middleware([
    Aleksa\Library\Middlewares\JsonMiddleware::class,
    Aleksa\Library\Middlewares\LocaleMiddleware::class,
    Aleksa\Library\Middlewares\CorsMiddleware::class,
    Aleksa\Library\Middlewares\ApiRequestMiddleware::class
]);

/**
 * Custom ServiceProviders
 */
$app->register(Aleksa\Locale\LocaleServiceProvider::class);
$app->register(Aleksa\User\UserServiceProvider::class);
$app->register(Aleksa\Auth\AuthServiceProvider::class);

return $app;
