<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_article', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('users');
            
            $table->bigInteger('multimedia_id')->unsigned()->nullable()->index();
            $table->foreign('multimedia_id')->references('id')->on('multimedia');
            
            $table->string('path')->unique();
            $table->string('title');
            $table->mediumText('body');
            $table->timestamps();
            // $table->unique(array('path', 'deleted_at'));
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
        Schema::dropIfExists('static_article');
    }
}
