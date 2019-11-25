<?php

namespace Aleksa\User\Events;

use Laravel\Lumen\Providers\EventServiceProvider;

class UserEventServiceProvider extends EventServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'Aleksa\User\Events\UserCreated' => [
            'Aleksa\User\Listeners\UserCreatedListener',
        ]

    ];
}
