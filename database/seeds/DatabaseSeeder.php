<?php

use Illuminate\Database\Seeder;
use Aleksa\User\Database\Seeds\UserTableSeeder;
use Aleksa\Locale\Database\Seeds\LocaleTableSeeder;
use Aleksa\UserGroup\Database\Seeds\UserGroupTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserGroupTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(LocaleTableSeeder::class);
    }
}
