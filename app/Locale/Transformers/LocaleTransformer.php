<?php

namespace Aleksa\Locale\Transformers;

use Aleksa\Locale\Models\Locale;
use League\Fractal\TransformerAbstract;

class LocaleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'translation',
        'translations'
    ];

    public function transform(Locale $locale)
    {
        return [
            'id'         => (int)$locale->id,
            'code'       => (string)$locale->code,
            'created_at' => (string)$locale->created_at,
            'updated_at' => (string)$locale->updated_at
        ];
    }

    public function includeTranslation(Locale $locale)
    {
        $localeTranslationTransformer = app('Aleksa\Locale\Translation\Transformers\LocaleTranslationTransformer');

        if ($locale->translation) {
            return $this->item($locale->translation, $localeTranslationTransformer);
        }
    }

    public function includeTranslations(Locale $locale)
    {
        $localeTranslationTransformer = app('Aleksa\Locale\Translation\Transformers\LocaleTranslationTransformer');

        if ($locale->translations) {
            return $this->collection($locale->translations, $localeTranslationTransformer);
        }
    }
}
