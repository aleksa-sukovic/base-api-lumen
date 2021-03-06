<?php

$app = app();

$app->router->group(
    ['prefix' => 'v1', 'middleware' => 'auth:true'],
    function () use ($app) {
        $app->router->get('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@show');
        $app->router->post('/locales', 'Aleksa\Locale\Controllers\LocaleController@store');
        $app->router->put('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@update');
        $app->router->delete('/locales/{id:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@destroy');

        $app->router->delete('/locales/{id:[0-9]+}/translations/{translationId:[0-9]+}', 'Aleksa\Locale\Controllers\LocaleController@destroyTranslationById');
        $app->router->delete('/locales/{id:[0-9]+}/translation', 'Aleksa\Locale\Controllers\LocaleController@destroyTranslation');
    }
);

$app->router->group(
    ['prefix' => 'v1', 'middleware' => 'auth:false'],
    function () use ($app) {
        $app->router->get('/locales', 'Aleksa\Locale\Controllers\LocaleController@index');
    }
);
