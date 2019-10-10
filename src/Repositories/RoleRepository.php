<?php

namespace Lvmod\ControlPanel\Repositories;

use Lvmod\ControlPanel\Models\User;
use Lvmod\ControlPanel\Models\Role;

class RoleRepository {


    /**
     * Получить все роли.
     *
     * @return Collection
     */
    public function find() {
        return Role::all();
    }

     /**
     * Получить роль по названию
     *
     * @return Role
     */
    public function byName($name) {
        return Role::where('name', $name)->first();
    }

}
