<?php

use Aleksa\User\Models\User;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->email,
        'birth_date' => $faker->date(),
        'password' => Hash::make('123123'),
        'gender' => $faker->randomElement(['m', 'f'])
    ];
});
