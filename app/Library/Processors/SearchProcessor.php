<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;
use Aleksa\Library\Processors\BaseProcessor;

class SearchProcessor extends BaseProcessor
{

    public function process(Builder $query, $params): Builder
    {
        foreach ($params as $key => $value) {
            if(!in_array($key, $this->processableParams)) {
                continue;
            }

            $query->where($key, 'like', '%' . $value . '%');
        }

        return $query;
    }
}
