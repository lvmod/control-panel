<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new \Lvmod\ControlPanel\Models\Role();
        $role->name = "developer";
        $role->save();
        
        $role = new \Lvmod\ControlPanel\Models\Role();
        $role->name = "admin";
        $role->save();
        
        $role = new \Lvmod\ControlPanel\Models\Role();
        $role->name = "user";
        $role->save();
        
    }
}
