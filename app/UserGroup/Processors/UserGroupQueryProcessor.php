<?php

namespace Aleksa\UserGroup\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class UserGroupQueryProcessor extends QueryProcessor
{
    protected $processors = [
        'Aleksa\UserGroup\Processors\UserGroupOrderProcessor'
    ];
}
