<?php

namespace Aleksa\Locale\Database\Seeds;

use Aleksa\Locale\Models\Locale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Aleksa\Library\Database\Seeds\TableSeeder;

class LocaleTableSeeder extends TableSeeder
{
    public function seed()
    {
        DB::table('locales')->truncate();

        DB::table('locales')->insert([
            [
                'code'       => 'en',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'code'       => 'me',
                'created_at' => Carbon::now(),
                'updated_at' =>  Carbon::now()
            ]
        ]);
    }
}
