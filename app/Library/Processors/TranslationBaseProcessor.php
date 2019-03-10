<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

abstract class TranslationBaseProcessor
{
    protected $processableParams;

    abstract public function process(Builder $query, $params, $translationTableName = ''): Builder;
}
