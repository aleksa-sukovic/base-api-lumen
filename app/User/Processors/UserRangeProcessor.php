<?php

namespace Aleksa\User\Processors;

use Aleksa\Library\Processors\RangeProcessor;

class UserRangeProcessor extends RangeProcessor
{
    protected $processableParams = [
        'created_at',
        'id'
    ];
}
