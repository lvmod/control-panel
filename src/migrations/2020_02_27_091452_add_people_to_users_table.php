<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeopleToUsersTable extends Migration
{
    protected $tableName = "users";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'people_id')) {
            return;
        }

        Schema::table($this->tableName, function (Blueprint $table) {
            $table->bigInteger('people_id')->unsigned()->nullable();
            $table->foreign('people_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('users', 'people_id')) {
            return;
        }

        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropForeign('users_people_id_foreign');
            $table->dropColumn('people_id');
        });
    }
}
