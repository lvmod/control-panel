<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\Role;
use Lvmod\ControlPanel\Models\RoleUser;
use Illuminate\Support\Facades\DB;

class UserRepository {


    public function find() {
        return User::orderBy('created_at', 'asc')
        ->get();
    }

    public function byEmail($email) {
        return User::where('email', $email)->first();
    }

    public function hasRole(User $user, $roleName) {
        return DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', '=', $user->id)
                ->where('roles.name', '=', $roleName)
                ->count();
    }

}
