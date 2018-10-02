<?php

namespace Aleksa\Locale\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class LocaleQueryProcessor extends QueryProcessor
{
    protected $processors = [
        'Aleksa\Locale\Processors\LocaleFilterProcessor',
        'Aleksa\Locale\Processors\LocaleSearchProcessor',
        'Aleksa\Locale\Processors\LocaleOrderProcessor'
    ];
}
