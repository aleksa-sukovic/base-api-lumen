<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;

class RangeProcessor extends BaseProcessor
{
    protected $fromPrefix = 'from';
    protected $toPrefix   = 'to';

    public function process(Builder $query, $params): Builder
    {
        $rangeParams = [];

        foreach ($params as $key => $value) {
            if (!$this->isParam($key, 'from') && !$this->isParam($key, 'to')) {
                continue;
            }

            $rangeParams = $this->addRangeParam($rangeParams, $key, $value);
        }

        return $this->processRanges($query, $rangeParams);

        return $query;
    }

    private function addRangeParam($array, $key, $value)
    {
        $label = $this->isParam($key, 'from') ? 'from' : 'to';

        $attributeName = $this->getAttributeName($key);

        $array[$attributeName][$label] = $value;

        return $array;
    }

    protected function getAttributeName($rangeParam)
    {
        $type = $this->isParam($rangeParam, 'from') ? 'from' : 'to';

        return substr($rangeParam, strlen($type) + 1);
    }

    protected function isParam($param, $type)
    {
        $param = substr($param, strlen($type) + 1);

        foreach ($this->processableParams as $key) {
            if ($key == $param) {
                return true;
            }
        }

        return false;
    }

    private function processRanges(Builder $query, $params)
    {
        foreach ($params as $param => $values) {
            if (isset($values['from']) && isset($values['to'])) {
                $query->whereBetween($param, [ $values['from'], $values['to'] ]);
            } elseif (isset($values['from'])) {
                $query->where($param, '>=', $values['from']);
            } elseif (isset($values['to'])) {
                $query->where($param, '<=', $values['to']);
            }
        }

        return $query;
    }
}
