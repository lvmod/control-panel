<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('inline')->nullable();

            $table->bigInteger('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('users');

            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('category');

            $table->bigInteger('multimedia_id')->unsigned()->nullable()->index();
            $table->foreign('multimedia_id')->references('id')->on('multimedia');

            $table->string('title');
            $table->mediumText('body');
            $table->dateTime('created')->nullable();
            $table->dateTime('posted')->nullable();
            $table->boolean('visible')->nullable()->index();
            $table->timestamps();
            // $table->softDeletes(); //Мягкое удаление https://laravel.ru/docs/v5/eloquent#%D0%BC%D1%8F%D0%B3%D0%BA%D0%BE%D0%B5
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
