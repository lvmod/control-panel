<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;
use \Lvmod\ControlPanel\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => 'developer'], []);
        Role::firstOrCreate(['name' => 'admin'], []);
        Role::firstOrCreate(['name' => 'user'], []);
    }
}
