<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryPhotoMultimediaTable extends Migration
{
    protected $tableName = "gallery_photo_multimedia";
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('priority')->nullable()->index();
            
            $table->bigInteger('gallery_photo_id')->unsigned()->index();
            $table->foreign('gallery_photo_id')->references('id')->on('gallery_photo')->onDelete('cascade');

            $table->bigInteger('multimedia_id')->unsigned()->index();
            $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');

            $table->timestamps();
        });

        DB::unprepared("
            CREATE TRIGGER tr_".$this->tableName."_default_priority BEFORE INSERT ON `".$this->tableName."` FOR EACH ROW
            BEGIN
                declare v_id bigint default 0;
            
                select auto_increment into v_id
                from information_schema.tables
                where table_name = '".$this->tableName."'
                and table_schema = database();
                SET NEW.priority = v_id;
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_'.$this->tableName.'_default_priority`');
        Schema::dropIfExists($this->tableName);
    }
}
