<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultimediaTrashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia_trash', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->string('name');
            $table->string('file_name')->nullable();
            $table->integer('type_id')->unsigned()->index();
            $table->boolean('isfolder')->nullable();
            $table->string('external_url')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('multimedia_trash');
    }
}
