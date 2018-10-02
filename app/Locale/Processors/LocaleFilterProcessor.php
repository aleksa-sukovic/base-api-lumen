<?php

namespace Aleksa\Locale\Processors;

use Aleksa\Library\Processors\FilterProcessor;

class LocaleFilterProcessor extends FilterProcessor
{
    protected $processableParams = [
        'id', 'code'
    ];
}
