<?php

namespace Aleksa\Locale\Database\Factories;

use Aleksa\Library\Database\Factories\ObjectFactory;
use Faker\Generator;

class LocaleModelFactory extends ObjectFactory
{
    protected $modelClass = 'Aleksa\Locale\Models\Locale';

    protected function make(Generator $generator): array
    {
        return [
            'code'       => $generator->randomElement(['me', 'en', 'fr', 'es']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
