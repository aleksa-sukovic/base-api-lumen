<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;
use CaseConverter\CaseString;

class RangeProcessor extends BaseProcessor
{
    protected $fromPrefix   = 'from';
    protected $toPrefix     = 'to';

    public function process(Builder $query, $params): Builder
    {
        $rangeParams = [];

        foreach ($params as $key => $value) {
            if (!$this->isParam($key, 'from') && !$this->isParam($key, 'to')) {
                continue;
            }

            $rangeParams = $this->addRangeParam($rangeParams, $key, $value);
        }

        foreach ($rangeParams as $param => $values) {
            if (!isset($values['from']) || !isset($values['to'])) {
                continue;
            }

            $query->whereBetween($param, [ $values['from'], $values['to'] ]);
        }

        return $query;
    }

    private function addRangeParam($array, $key, $value)
    {
        $label = $this->isParam($key, 'from') ? 'from' : 'to';

        $key = $this->convertRangeParam($key);

        $array[$key][$label] = $value;

        return $array;
    }

    protected function isParam($param, $type)
    {
        $param = CaseString::camel(substr($param, strlen($type)))->snake();

        foreach ($this->processableParams as $key) {
            if ($key == $param) {
                return true;
            }
        }

        return false;
    }

    protected function convertRangeParam($param)
    {
        $type = $this->isParam($param, 'from') ? 'from' : 'to';

        return CaseString::camel(substr($param, strlen($type)))->snake();
    }
}
