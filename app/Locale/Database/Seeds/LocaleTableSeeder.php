<?php

namespace Aleksa\Locale\Database\Seeds;

use Illuminate\Database\Seeder;
use Aleksa\Locale\Models\Locale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class LocaleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('locales')->truncate();

        DB::table('locales')->insert([
            [
                'code'       => 'en',
                'display'    => 'English',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'code'       => 'me',
                'display'    => 'Montenegrin',
                'created_at' => Carbon::now(),
                'updated_at' =>  Carbon::now()
            ]
        ]);
    }
}
