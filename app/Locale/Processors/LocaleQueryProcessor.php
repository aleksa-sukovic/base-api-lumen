<?php

namespace Aleksa\Locale\Processors;

use Aleksa\Library\Processors\QueryProcessor;

class LocaleQueryProcessor extends QueryProcessor
{
    protected $tableName = 'locales';
    protected $translationTableName = 'locale_translations';

    protected $processors = [
        'Aleksa\Locale\Processors\LocaleFilterProcessor',
        'Aleksa\Locale\Processors\LocaleSearchProcessor',
        'Aleksa\Locale\Processors\LocaleOrderProcessor'
    ];

    protected $translationProcessors = [
        'Aleksa\Locale\Processors\LocaleTranslationOrderProcessor'
    ];
}
