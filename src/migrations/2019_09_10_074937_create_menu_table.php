<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('path')->nullable();
            $table->string('active_path')->nullable();  
            $table->integer('parent_id')->nullable()->unsigned()->index();

            //Позиция размещения пунтка меню на уровне parent_id.
            //place_id идентификатор пункта меню до,вместо или после которого нужно разместить текущий пункт меню.
            //Если place_id имете parent_id отличный от parent_id текущего элемента, то позиция размещения игнорируется.
            //Если place_type first или end, то place_id не учитывается и элемент размещается певым или последним для parent_id
            $table->integer('place_id')->nullable()->unsigned()->index();
            $table->string('place_type')->nullable();  //first|before|instead|after|end (первым, до place_id, вместо place_id, после place_id, последним)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
