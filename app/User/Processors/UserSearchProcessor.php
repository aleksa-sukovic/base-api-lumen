<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\SearchProcessor;

class UserSearchProcessor extends SearchProcessor
{
    protected $processableParams = [
        'full_name'
    ];
}
