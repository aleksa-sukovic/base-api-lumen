<?php

namespace Aleksa\User\Database\Factories;

use Faker\Generator;
use Aleksa\Library\Database\Factories\ObjectFactory;
use Illuminate\Support\Facades\Hash;

class UserModelFactory extends ObjectFactory
{
    protected $modelClass = 'Aleksa\User\Models\User';

    protected function make(Generator $generator): array
    {
        return [
            'full_name'  => $generator->name,
            'email'      => $generator->email,
            'birth_date' => $generator->date(),
            'group_id'   => $generator->randomElement([1, 2, 3, 4]),
            'password'   => Hash::make('123123'),
            'gender'     => $generator->randomElement(['m', 'f'])
        ];
    }
}
