<?php

namespace Aleksa\Library\Services;

class Translator
{
    public static function get(string $key = '')
    {
        return trans($key, [], LocaleService::get()->code);
    }

    public static function getIn(string $key, string $localeCode = '')
    {
        return trans($key, [], $localeCode);
    }
}
