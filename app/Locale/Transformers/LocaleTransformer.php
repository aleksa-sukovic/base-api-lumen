<?php

namespace Aleksa\Locale\Transformers;

use Aleksa\Locale\Models\Locale;
use League\Fractal\TransformerAbstract;

class LocaleTransformer extends TransformerAbstract
{
    public function transform(Locale $locale)
    {
        return [
            'id'        => (int)$locale->id,
            'code'      => (string)$locale->code,
            'display'   => (string)$locale->display,
            'created_at'=> (string)$locale->created_at,
            'updated_at'=> (string)$locale->updated_at
        ];
    }
}