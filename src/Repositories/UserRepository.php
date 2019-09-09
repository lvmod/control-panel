<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\Role;
use Lvmod\ControlPanel\Models\RoleUser;
use Illuminate\Support\Facades\DB;

class UserRepository {


    public function find() {
        return Role::all();
    }

    public function byEmail($email) {
        return Role::where('email', $email)->first();
    }

    public function hasRole(User $user, $roleName) {
        return DB::table('role_user')
                ->join('roles', 'role_user.role', '=', 'roles.id')
                ->where('role_user.user', '=', $user->id)
                ->where('roles.name', '=', $roleName)
                ->count();
    }

}
