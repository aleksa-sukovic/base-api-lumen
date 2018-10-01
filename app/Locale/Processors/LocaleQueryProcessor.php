<?php

namespace Aleksa\Locale\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class LocaleQueryProcessor extends QueryProcessor
{
    protected $filterableParams = ['id', 'code'];
    protected $searchableParams = ['display'];
}