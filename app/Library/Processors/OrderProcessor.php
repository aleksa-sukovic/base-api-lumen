<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;

class OrderProcessor extends BaseProcessor
{
    protected $order   = 'asc';
    protected $orderBy = 'id';

    public function process(Builder $query, $params): Builder
    {
        $this->processParams($params);

        $query->orderBy($this->orderBy, $this->order);

        return $query;
    }

    private function processParams($params)
    {
        $this->processOrderParams($params);
        $this->processOrderByParams($params);
    }

    private function processOrderParams($params)
    {
        if(!isset($params['order'])) {
            return;
        }

        $order = strtolower($params['order']);
        if($order == 'asc' || $order == 'desc') {
            $this->order = $order;
        }
    }

    private function processOrderByParams($params)
    {
        if(isset($params['order_by']) && in_array($params['order_by'], $this->processableParams)) {
            $this->orderBy = $params['order_by'];
        }
    }
}
