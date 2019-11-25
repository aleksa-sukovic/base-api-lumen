<?php

return [
    'driver' => env('MAIL_DRIVER', 'log'),
    'host'   => env('MAIL_HOST', 'smtp.mailgun.org'),
    'port'   => env('MAIL_PORT', 2525),
    'from'   => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name'    => env('MAIL_FROM_NAME', 'Example'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username'   => env('MAIL_USERNAME'),
    'password'   => env('MAIL_PASSWORD'),
    'sendmail'   => '/usr/sbin/sendmail -bs',
    'markdown'   => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ]
];
