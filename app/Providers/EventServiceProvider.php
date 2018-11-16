<?php

namespace Aleksa\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Aleksa\Events\ExampleEvent' => [
            'Aleksa\Listeners\ExampleListener',
        ],
    ];
}
