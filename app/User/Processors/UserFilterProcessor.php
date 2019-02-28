<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\FilterProcessor;

class UserFilterProcessor extends FilterProcessor
{
    protected $processableParams = [
        'id',
        'email',
        'gender',
        'group_id'
    ];
}
