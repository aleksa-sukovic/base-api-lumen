<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocaleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locale_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('locale_parent_id')->default(0);
            $table->unsignedInteger('locale_id')->default(0);
            $table->string('name')->default('');
            $table->timestamps();

            $table->unique(['locale_parent_id', 'locale_id']);
            $table->foreign('locale_parent_id')->references('id')->on('locales')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('locale_id')->references('id')->on('locales')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('locale_translations');
    }
}
