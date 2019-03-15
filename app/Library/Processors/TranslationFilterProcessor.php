<?php

namespace Aleksa\Library\Processors;

use Illuminate\Database\Eloquent\Builder;

class TranslationFilterProcessor extends TranslationBaseProcessor
{
    public function process(Builder $query, $params, $translationTableName = ''): Builder
    {
        foreach ($params as $key => $value) {
            if (!in_array($key, $this->processableParams)) {
                continue;
            }

            $query->where($translationTableName . '.' . $key, '=', $value);
        }

        return $query;
    }
}
