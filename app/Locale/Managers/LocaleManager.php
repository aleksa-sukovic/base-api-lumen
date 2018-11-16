<?php

namespace Aleksa\Locale\Managers;

class LocaleManager
{
    private static $defaultLocaleCode = 'en';

    private static $locale     = null;
    private static $repository = null;

    public static function code()
    {
        return self::locale()->code;
    }

    public static function locale($locale = null)
    {
        if ($locale !== null) {
            return self::setLocale($locale);
        }

        return self::$locale !== null ? self::$locale : self::getDefaultLocale();
    }

    private static function setLocale($localeCode)
    {
        $repository = self::getRepository();
        $locale     = $repository->findByCode($localeCode);

        if ($locale) {
            return (self::$locale = $locale);
        }

        return self::$locale !== null ? self::$locale : self::getDefaultLocale();
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
