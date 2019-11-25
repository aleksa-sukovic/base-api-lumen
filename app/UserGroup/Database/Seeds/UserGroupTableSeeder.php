<?php

namespace Aleksa\UserGroup\Database\Seeds;

use Aleksa\UserGroup\Models\UserGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Aleksa\Library\Database\Seeds\TableSeeder;

class UserGroupTableSeeder extends TableSeeder
{
    public function seed()
    {
        DB::table('user_groups')->truncate();

        DB::table('user_groups')->insert([
            [
                'name'       => 'super-admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'name'       => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'name'       => 'editor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'name'       => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
