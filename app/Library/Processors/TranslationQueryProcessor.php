<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class TranslationQueryProcessor extends QueryProcessor
{
    protected $translationTableName;
    protected $translationProcessors;

    public function __construct()
    {
        parent::__construct();

        foreach ($this->translationProcessors as $index => $processor) {
            $this->translationProcessors[$index] = new $processor;
        }
    }

    public function process(Builder $query, $params)
    {
        $query = parent::process($query, $params);

        foreach ($this->translationProcessors as $processor) {
            $query = $processor->process($query, $params, $this->translationTableName);
        }

        return $query;
    }
}
