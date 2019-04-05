<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseProcessor
{
    protected $processableParams;

    abstract public function process(Builder $query, $params, $tableName = ''): Builder;
}
