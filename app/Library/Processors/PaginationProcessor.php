<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;

class PaginationProcessor extends BaseProcessor
{
    protected $offset = 0;
    protected $limit  = 10;

    public function process(Builder $query, $params): Builder
    {
        if (isset($params['limit'])) {
            $this->limit = $params['limit'];
        }

        if (isset($params['offset'])) {
            $this->offset = $params['offset'];
        }

        return $this->paginate($query);
    }

    protected function paginate(Builder $query)
    {
        return $query
            ->offset($this->offset)
            ->limit($this->limit);
    }
}
