<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materials extends Model {

    /**
     * transient field
     * Временное поле для хранения пути файла. Не сохраняется в базе данных
     */
    public $path;
    public $pathMin;
    protected $appends = ['path', 'pathMin'];

    protected $table = 'materials';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    public function own() {
        $this->morphTo();
    }

    public function type() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\MultimediaType');
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
