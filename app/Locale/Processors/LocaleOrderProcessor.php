<?php

namespace Aleksa\Locale\Processors;

use Aleksa\Library\Processors\OrderProcessor;

class LocaleOrderProcessor extends OrderProcessor
{
    protected $processableParams = [
        'id',
        'code'
    ];
}
