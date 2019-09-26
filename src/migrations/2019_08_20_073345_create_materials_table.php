<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('file_name')->nullable();
            $table->string('url')->nullable();
            $table->integer('type_id')->unsigned()->index();
            $table->boolean('is_main')->nullable();
            $table->string('external_url')->nullable();
            $table->string('description')->nullable();

            //laravel.ru/docs/v5/eloquent-relationships#pl
            //https://blog.logrocket.com/polymorphic-relationships-in-laravel/
            $table->morphs('own');

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
        Schema::dropIfExists('materials');
    }
}
