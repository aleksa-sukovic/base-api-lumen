<?php

use Illuminate\Database\Seeder;
use Aleksa\User\Database\Seeds\UserTableSeeder;
use Aleksa\Locale\Database\Seeds\LocaleTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(LocaleTableSeeder::class);
    }
}
