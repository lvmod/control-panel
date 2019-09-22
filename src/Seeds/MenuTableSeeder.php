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
        $object->icon = "fa fa-home";
        $object->path = "/control";
        $object->active_path = null;
        $object->parent_id = null;
        $object->place_id = null;
        $object->place_type = Menu::$PLACE_TYPE_FIRST;
        $object->save();
        
        $object = new Menu();
        $object->title = "Файлы";
        $object->icon = "fa fa-folder-open";
        $object->path = "/control/files";
        $object->save();

        $object = new Menu();
        $object->title = "Материалы";
        $object->icon = "fa fa-files-o";
        $object->save();
        $materialId = $object->id;

        $object = new Menu();
        $object->title = "Новости";
        $object->icon = "fa fa-circle-o";
        $object->path = "/control/news";
        $object->parent_id = $materialId;
        $object->save();

        $object = new Menu();
        $object->title = "Статьи";
        $object->icon = "fa fa-circle-o";
        $object->path = "/control/article";
        $object->parent_id = $materialId;
        $object->save();
        
        $object = new Menu();
        $object->title = "Фиксированные статьи";
        $object->icon = "fa fa-circle-o";
        $object->path = "/control/static/article";
        $object->parent_id = $materialId;
        $object->save();
        
        $object = new Menu();
        $object->title = "Сайт";
        $object->icon = "fa fa-share";
        $object->target = "_blank";
        $object->path = "/";
        $object->place_type = Menu::$PLACE_TYPE_LAST;
        $object->save();
    }
}
