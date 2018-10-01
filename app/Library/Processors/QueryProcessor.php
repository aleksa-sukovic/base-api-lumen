<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class QueryProcessor
{
    protected $query;

    public function process(Builder $query, $params)
    {
        $query = $this->filter($query, $params);
        $query = $this->search($query, $params);

        return $query;
    }

    protected function search(Builder $query, $params)
    {
        foreach ($params as $key => $value) {
            if(!in_array($key, $this->searchableParams)) {
                continue;
            }

            $query->where($key, 'like', '%' . $value . '%');
        }

        return $query;
    }

    protected function filter(Builder $query, $params)
    {
        foreach ($params as $key => $value) {
            if(!in_array($key, $this->filterableParams)) {                
                continue;
            }

            $query->where($key, '=', $value);
        }
        
        return $query;
    }

}