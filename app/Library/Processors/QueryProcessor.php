<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class QueryProcessor
{
    protected $tableName;
    protected $translationTableName;
    protected $processors;
    protected $translationProcessors;

    public function __construct()
    {
        foreach ($this->processors as $index => $processor) {
            $this->processors[$index] = new $processor;
        }

        if ($this->translationProcessors) {
            foreach ($this->translationProcessors as $index => $processor) {
                $this->translationProcessors[$index] = new $processor;
            }
        }
    }

    public function process(Builder $query, $params, $skipPagination = false)
    {
        $query = $this->runBaseProcessors($query, $params, $skipPagination);

        if ($this->translationProcessors) {
            $query = $this->runTranslationProcessors($query, $params, $skipPagination);
        }

        return $query;
    }

    protected function runBaseProcessors(Builder $query, $params, $skipPagination = false): Builder
    {
        foreach ($this->processors as $processor) {
            if ($skipPagination && is_subclass_of($processor, PaginationProcessor::class)) {
                continue;
            }

            $query = $processor->process($query, $params, $this->tableName);
        }

        return $query;
    }

    protected function runTranslationProcessors(Builder $query, $params, $skipPagination = false): Builder
    {
        foreach ($this->translationProcessors as $processor) {
            if ($skipPagination && is_subclass_of($processor, PaginationProcessor::class)) {
                continue;
            }

            $query = $processor->process($query, $params, $this->translationTableName);
        }

        return $query;
    }
}
