<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryPhotoTable extends Migration
{
    protected $tableName = "gallery_photo";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('users');

            $table->double('priority')->nullable()->index();
            $table->string('title');
            $table->mediumText('body')->nullable();
            $table->dateTime('created')->nullable();
            $table->timestamps();
            // $table->softDeletes(); //Мягкое удаление https://laravel.ru/docs/v5/eloquent#%D0%BC%D1%8F%D0%B3%D0%BA%D0%BE%D0%B5
        });

        // DB::unprepared("
        //     CREATE TRIGGER tr_".$this->tableName."_default_priority BEFORE INSERT ON `".$this->tableName."` FOR EACH ROW
        //     BEGIN
        //         declare v_id bigint default 0;
            
        //         select auto_increment into v_id
        //         from information_schema.tables
        //         where table_name = '".$this->tableName."'
        //         and table_schema = database();
        //         SET NEW.priority = v_id;
        //     END
        // ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER `tr_'.$this->tableName.'_default_priority`');
        Schema::dropIfExists($this->tableName);
    }
}
