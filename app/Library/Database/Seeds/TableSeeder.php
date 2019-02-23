<?php

namespace Aleksa\Library\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

abstract class TableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->seed();

        Schema::enableForeignKeyConstraints();
    }

    abstract public function seed();
}
