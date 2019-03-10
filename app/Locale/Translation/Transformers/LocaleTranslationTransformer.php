<?php

namespace Aleksa\Locale\Translation\Transformers;

use Aleksa\Locale\Translation\Models\LocaleTranslation;
use League\Fractal\TransformerAbstract;

class LocaleTranslationTransformer extends TransformerAbstract
{
    public function transform(LocaleTranslation $localeTranslation)
    {
        return [
            'id'                     => (int)$localeTranslation->id,
            'name'                   => (string)$localeTranslation->name,
            'locale_parent_id'       => (int)$localeTranslation->locale_parent_id,
            'locale_id'              => (int)$localeTranslation->locale_id,
            'created_at'             => (string)$localeTranslation->created_at,
            'updated_at'             => (string)$localeTranslation->updated_at
        ];
    }
}
