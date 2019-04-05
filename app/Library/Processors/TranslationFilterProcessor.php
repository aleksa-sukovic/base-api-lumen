<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class TranslationFilterProcessor extends BaseProcessor
{
    public function process(Builder $query, $params, $tableName = ''): Builder
    {
        foreach ($params as $key => $value) {
            if (!in_array($key, $this->processableParams)) {
                continue;
            }

            $query->where($tableName . '.' . $key, '=', $value);
        }

        return $query;
    }
}
