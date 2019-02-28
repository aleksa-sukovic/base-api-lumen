<?php

namespace Aleksa\UserGroup\Database\Factories;

use Aleksa\Library\Database\Factories\ObjectFactory;
use Faker\Generator;

class UserGroupModelFactory extends ObjectFactory
{
    protected $modelClass = 'Aleksa\UserGroup\Models\UserGroup';

    protected function make(Generator $generator): array
    {
        return [
            'name'       => $generator->randomElement(['admin', 'super-admin', 'editor', 'user']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
