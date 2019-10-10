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
        Menu::firstOrCreate(['path' => '/control'], [
            'title' => 'Главная', 
            'icon' => 'fa fa-home',
            'place_type' => Menu::$PLACE_TYPE_FIRST
        ]);

        Menu::firstOrCreate(['path' => '/control/files'], [
            'title' => 'Файлы', 
            'icon' => 'fa fa-folder-open'
        ]);

        $object = Menu::firstOrCreate(['title' => 'Материалы'], [
            'icon' => 'fa fa-files-o'
        ]);

        $materialId = $object->id;

        Menu::firstOrCreate(['path' => '/control/news'], [
            'title' => 'Новости', 
            'icon' => 'fa fa-circle-o',
            'parent_id' => $materialId
        ]);

        Menu::firstOrCreate(['path' => '/control/article'], [
            'title' => 'Статьи', 
            'icon' => 'fa fa-circle-o',
            'parent_id' => $materialId
        ]);

        Menu::firstOrCreate(['path' => '/control/static/article'], [
            'title' => 'Фиксированные статьи', 
            'icon' => 'fa fa-circle-o',
            'parent_id' => $materialId
        ]);

        Menu::firstOrCreate(['path' => '/'], [
            'title' => 'Сайт', 
            'icon' => 'fa fa-share',
            'target' => '_blank',
            'place_type' => Menu::$PLACE_TYPE_LAST
        ]);

        Menu::firstOrCreate(['path' => '/control/gallery'], [
            'title' => 'Галерея', 
            'icon' => 'fa fa-picture-o'
        ]);
    }
}
