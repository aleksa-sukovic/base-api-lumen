<?php

namespace Aleksa\UserGroup\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class UserGroupQueryProcessor extends QueryProcessor
{
    protected $tableName = 'user_groups';

    protected $processors = [
        'Aleksa\UserGroup\Processors\UserGroupOrderProcessor'
    ];
}
