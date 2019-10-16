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
            $table->double('sort')->nullable()->index();
            
            $table->bigInteger('gallery_photo_id')->unsigned()->index();
            $table->foreign('gallery_photo_id')->references('id')->on('gallery_photo')->onDelete('cascade');

            $table->bigInteger('multimedia_id')->unsigned()->index();
            $table->foreign('multimedia_id')->references('id')->on('multimedia')->onDelete('cascade');

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
        Schema::dropIfExists($this->tableName);
    }
}
