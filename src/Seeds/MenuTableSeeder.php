<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;
use Lvmod\ControlPanel\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $object = new Menu();
        $object->title = "Главная";
        $object->path = "/control";
        $object->active_path = null;
        $object->parent_id = null;
        $object->place_id = null;
        $object->place_type = Menu::$PLACE_TYPE_FIRST;
        $object->save();
        
        
        $object = new Menu();
        $object->title = "Материалы";
        $object->save();
        $materialId = $object->id;

        $object = new Menu();
        $object->title = "Новости";
        $object->path = "/control/news";
        $object->parent_id = $materialId;
        $object->save();

        $object = new Menu();
        $object->title = "Статьи";
        $object->path = "/control/article";
        $object->parent_id = $materialId;
        $object->save();
        
        $object = new Menu();
        $object->title = "Сайт";
        $object->path = "/";
        $object->place_type = Menu::$PLACE_TYPE_LAST;
        $object->save();
    }
}
