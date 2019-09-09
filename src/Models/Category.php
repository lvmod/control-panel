<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {

    //Мягкое удаление https://laravel.ru/docs/v5/eloquent#%D0%BC%D1%8F%D0%B3%D0%BA%D0%BE%D0%B5
    use SoftDeletes;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'сtegory';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //Один ко многим https://laravel.ru/docs/v5/eloquent-relationships#om
    /**
     * Получить новости раздела.
     */
    public function news() {
        return $this->hasMany('Lvmod\ControlPanel\Models\News', 'category');
    }
}
