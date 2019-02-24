<?php

$app = app();

$app->router->post('/auth/login', 'Aleksa\Auth\Controllers\AuthController@login');
$app->router->post('/auth/refresh', 'Aleksa\Auth\Controllers\AuthController@refresh');
$app->router->post('/auth/{id:[0-9]+}/revoke', 'Aleksa\Auth\Controllers\AuthController@revoke');
$app->router->post('/auth/{id:[0-9]+}/reset', 'Aleksa\Auth\Controllers\AuthController@reset');