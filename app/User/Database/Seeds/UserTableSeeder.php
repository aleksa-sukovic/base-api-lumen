<?php

namespace Aleksa\User\Database\Seeds;

use Illuminate\Database\Seeder;
use Aleksa\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'full_name'  => 'Aleksa Sukovic',
                'email'      => 'sukovic.aleksa@gmail.com',
                'password'   => Hash::make('123123'),
                'gender'     => 'm',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        factory(User::class, 20)->create();
    }
}
