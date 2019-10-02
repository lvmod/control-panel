<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//Рекомендации для условия WHERE при добавлении в запрос мягко удалённых моделей условий orWhere
//https://laravel.ru/docs/v5/eloquent#%D0%B3%D0%B5%D0%BD%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D1%8F-30

class Article extends Model {

    //Мягкое удаление https://laravel.ru/docs/v5/eloquent#%D0%BC%D1%8F%D0%B3%D0%BA%D0%BE%D0%B5
    // use SoftDeletes;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'article';

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
    // protected $dates = ['deleted_at'];

    //Один ко многим (Обратное отношение)https://laravel.ru/docs/v5/eloquent-relationships#%D0%BE%D0%B4%D0%B8%D0%BD
    /**
     * Получить автора статьи
     */
    public function author() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\User');
    }

    //Один ко многим (Обратное отношение)https://laravel.ru/docs/v5/eloquent-relationships#%D0%BE%D0%B4%D0%B8%D0%BD
    
    public function multimedia() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\Multimedia');
    }
    
    public function materials() {
        return $this->morphMany('Lvmod\ControlPanel\Models\Materials', 'own');
    }

    /**
    * Атрибуты, которые должны быть преобразованы к базовым типам.
    * https://laravel.ru/docs/v5/eloquent-mutators#%D0%BF%D1%80%D0%B5%D0%BE%D0%B1%D1%80%D0%B0%D0%B7%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5_%D0%B0%D1%82%D1%80%D0%B8%D0%B1%D1%83%D1%82%D0%BE%D0%B2
    * 
    * @var array
    */
    protected $casts = [
      'visible' => 'boolean',
    ];

    public function baseImageUrl() {
        if($this->multimedia && $this->multimedia->file_name) { 
            return app()->Utils->basePath().'/'.$this->multimedia->file_name;
        } else if($this->image) { 
            return $this->image;
        } 
        return "";
    }
    
    public function getUrl() {
        return "/control/article/edit/".$this->id;
    }
}
