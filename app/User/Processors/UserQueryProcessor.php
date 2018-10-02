<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class UserQueryProcessor extends QueryProcessor
{
    protected $processors = [
        'Aleksa\User\Processors\UserFilterProcessor',
        'Aleksa\User\Processors\UserSearchProcessor',
        'Aleksa\User\Processors\UserOrderProcessor'
    ];
}
