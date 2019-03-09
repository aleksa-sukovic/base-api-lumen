<?php

$app = app();

$app->router->group(
    ['prefix' => 'v1', 'middleware' => 'auth'],
    function () use ($app) {
        $app->router->get('/user-groups', 'Aleksa\UserGroup\Controllers\UserGroupController@index');
        $app->router->get('/user-groups/{id:[0-9]+}', 'Aleksa\UserGroup\Controllers\UserGroupController@show');
        $app->router->post('/user-groups', 'Aleksa\UserGroup\Controllers\UserGroupController@store');
        $app->router->put('/user-groups/{id:[0-9]+}', 'Aleksa\UserGroup\Controllers\UserGroupController@update');
        $app->router->delete('/user-groups/{id:[0-9]+}', 'Aleksa\UserGroup\Controllers\UserGroupController@destroy');
    }
);
