<?php
namespace Lvmod\ControlPanel\Seeds;

use Illuminate\Database\Seeder;
use Lvmod\ControlPanel\Models\User;
use Lvmod\ControlPanel\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "Admin",
            'email' => "editorsite@mail.ru",
            'password' => bcrypt('nTsC54-12.dn'),
        ]);
        $role = Role::where('name', "admin")->first();
        $user->roles()->attach($role->id);
    }
}
