<?php

$app = app();

$app->router->group(
    ['prefix' => 'v1', 'middleware' => 'auth'],
    function () use ($app) {
        $app->router->get('/users', 'Aleksa\User\Controllers\UserController@index');
        $app->router->get('/users/{id:[0-9]+}', 'Aleksa\User\Controllers\UserController@show');
        $app->router->post('/users', 'Aleksa\User\Controllers\UserController@store');
        $app->router->put('/users/{id:[0-9]+}', 'Aleksa\User\Controllers\UserController@update');
        $app->router->delete('/users/{id:[0-9]+}', 'Aleksa\User\Controllers\UserController@destroy');
    }
);
