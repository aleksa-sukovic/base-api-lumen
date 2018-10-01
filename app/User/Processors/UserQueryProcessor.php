<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class UserQueryProcessor extends QueryProcessor
{
    protected $filterableParams = ['gender', 'email'];
    protected $searchableParams = ['full_name'];
}
