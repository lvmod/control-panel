<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multimedia extends Model {

    /**
     * transient field
     * Временное поле для хранения пути файла. Не сохраняется в базе данных
     */
    public $path;
    public $pathMin;
    protected $appends = ['path', 'pathMin'];

    protected $table = 'multimedia';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    public function parent() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\Multimedia');
    }

    public function type() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\MultimediaType');
    }

    public function items() {
        return $this->hasMany('Lvmod\ControlPanel\Models\Multimedia', 'parent_id');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'multimedia_user');
    }

    public function news() {
        return $this->hasMany('Lvmod\ControlPanel\Models\News');
    }

    public function articles() {
        return $this->hasMany('Lvmod\ControlPanel\Models\Article');
    }

    public function staticArticles() {
        return $this->hasMany('Lvmod\ControlPanel\Models\StaticArticle');
    }

    public function getPathAttribute()
    {
        return $this->path;
    }

    public function getPathMinAttribute()
    {
        return $this->pathMin;
    }

}
