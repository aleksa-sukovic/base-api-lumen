<?php

namespace Aleksa\Library\Services;

class Lang
{
    private static $defaultLocaleCode = 'en';

    private static $locale     = null;
    private static $repository = null;

    public static function code()
    {
        return self::locale()->code;
    }

    public static function get()
    {
        if (self::$locale === null) {
            return self::getDefaultLocale();
        }

        return self::$locale;
    }

    public static function set($localeCode)
    {
        $repository = self::getRepository();
        $locale     = $repository->findByCode($localeCode);

        if (!$locale) {
            return;
        }

        self::$locale = $locale;
    }

    private static function getDefaultLocale()
    {
        $repository = self::getRepository();

        self::$locale = $repository->findByCode(self::$defaultLocaleCode);

        if (!self::$locale) {
            self::$locale = $repository->create(['code' => self::$defaultLocaleCode]);
        }

        return self::$locale;
    }

    private static function getRepository()
    {
        if (self::$repository === null) {
            self::$repository = app()->make('Aleksa\Locale\Repositories\LocaleRepository');
        }

        return self::$repository;
    }
}
