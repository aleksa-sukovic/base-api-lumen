<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class QueryProcessor
{
    protected $tableName;
    protected $processors;

    public function __construct()
    {
        foreach ($this->processors as $index => $processor) {
            $this->processors[$index] = new $processor;
        }
    }

    public function process(Builder $query, $params)
    {
        foreach ($this->processors as $processor) {
            $query = $processor->process($query, $params, $this->tableName);
        }

        return $query;
    }
}
