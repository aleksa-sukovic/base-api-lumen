<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;

class OrderProcessor extends BaseProcessor
{
    protected $order;
    protected $orderBy;

    public function process(Builder $query, $params, $tableName = ''): Builder
    {
        $this->processParams($params);

        if ($this->orderBy && $this->order) {
            $query->orderBy($tableName . '.' . $this->orderBy, $this->order);
        }

        return $query;
    }

    private function processParams($params)
    {
        $this->processOrderParams($params);
        $this->processOrderByParams($params);
    }

    private function processOrderParams($params)
    {
        if (!isset($params['order'])) {
            return;
        }

        $order = strtolower($params['order']);
        if ($order == 'asc' || $order == 'desc') {
            $this->order = $order;
        }
    }

    private function processOrderByParams($params)
    {
        if (isset($params['orderby']) && in_array($params['orderby'], $this->processableParams)) {
            $this->orderBy = $params['orderby'];
        }
    }
}
