<?php

namespace Aleksa\UserGroup\Processors;

use Aleksa\Library\Processors\OrderProcessor;

class UserGroupOrderProcessor extends OrderProcessor
{
    protected $processableParams = [
        'name'
    ];
}
