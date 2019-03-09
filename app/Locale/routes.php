<?php

$app = app();

$app->router->group(
    ['prefix' => 'v1', 'middleware' => 'auth'],
    function () use ($app) {
        $app->router->get('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@show');
        $app->router->post('/locales', 'Aleksa\Locale\Controllers\LocaleController@store');
        $app->router->put('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@update');
        $app->router->delete('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@destroy');
    }
);

$app->router->group(
    ['prefix' => 'v1'],
    function () use ($app) {
        $app->router->get('/locales', 'Aleksa\Locale\Controllers\LocaleController@index');
    }
);
