<?php

namespace Aleksa\User\Database\Factories;

use Illuminate\Database\Eloquent\Factory;
use Faker\Generator;
use Aleksa\Library\Database\Factories\ObjectFactory;

class UserModelFactory extends ObjectFactory
{
    protected $modelClass = 'Aleksa\Library\User\Models\User';

    protected function make(Generator $generator): array
    {
        return [
            'full_name'  => $faker->name,
            'email'      => $faker->email,
            'birth_date' => $faker->date(),
            'password'   => Hash::make('123123'),
            'gender'     => $faker->randomElement(['m', 'f'])
        ];
    }
}
