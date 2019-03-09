<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->default('');
            $table->string('email')->default('');
            $table->timestamp('birth_date')->nullable();
            $table->string('gender')->default('');
            $table->string('password')->default('');
            $table->timestamps();

            $table->unique('email');
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
