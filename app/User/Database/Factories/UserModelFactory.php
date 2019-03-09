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

    protected function registerStates()
    {
        $this->factory->state('Aleksa\User\Models\User', 'super-admin', function () {
            return [
                'group_id' => 1
            ];
        });

        $this->factory->state('Aleksa\User\Models\User', 'admin', function () {
            return [
                'group_id' => 2
            ];
        });

        $this->factory->state('Aleksa\User\Models\User', 'editor', function () {
            return [
                'group_id' => 3
            ];
        });

        $this->factory->state('Aleksa\User\Models\User', 'user', function () {
            return [
                'group_id' => 4
            ];
        });
    }
}
