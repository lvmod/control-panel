<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;
use Lvmod\ControlPanel\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $object = new Category();
        $object->name = "Общая";
        $object->save();
        
    }
}
