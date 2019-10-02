<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Пользователи, принадлежащие роли.
     */
    public function users() {
        return $this->belongsToMany('Lvmod\ControlPanel\Models\User', 'role_user');
    }

}
