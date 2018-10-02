<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\OrderProcessor;

class UserOrderProcessor extends OrderProcessor
{
    protected $processableParams = [
        'id',
        'email',
        'full_name'
    ];
}
