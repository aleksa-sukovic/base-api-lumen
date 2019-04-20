<?php

$app = app();

$app->router->group(
    ['prefix' => 'v1'],
    function () use ($app) {
        $app->router->post('/auth/login', 'Aleksa\Auth\Controllers\AuthController@login');
        $app->router->post('/auth/refresh', 'Aleksa\Auth\Controllers\AuthController@refresh');
        $app->router->post('/auth/revoke', 'Aleksa\Auth\Controllers\AuthController@revoke');
        $app->router->post('/auth/reset', 'Aleksa\Auth\Controllers\AuthController@reset');
        $app->router->post('/auth/{code}/activate', 'Aleksa\Auth\Controllers\AuthController@activate');
    }
);
