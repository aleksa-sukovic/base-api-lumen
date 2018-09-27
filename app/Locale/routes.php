<?php

$app = app();

$app->router->get('/locales', 'Aleksa\Locale\Controllers\LocaleController@index');
