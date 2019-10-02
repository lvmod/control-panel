<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //Один ко многим https://laravel.ru/docs/v5/eloquent-relationships#om

    /**
     * Получить новости пользователя.
     */
    public function news() {
        return $this->hasMany('Lvmod\ControlPanel\Models\News', 'author_id');
    }

    /**
     * Роли, принадлежащие пользователю.
     */
    public function roles() {
        return $this->belongsToMany('Lvmod\ControlPanel\Models\Role', 'role_user');
    }

    public function multimedia() {
        return $this->belongsToMany('Lvmod\ControlPanel\Models\Multimedia', 'multimedia_user');
    }

    public function hasRole($role) {
        var_dump($this);
        die();
    }
}
