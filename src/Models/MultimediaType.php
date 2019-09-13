<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultimediaType extends Model {

    protected $table = 'multimedia_type';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    public function files() {
        return $this->hasMany('Lvmod\ControlPanel\Models\Multimedia', 'type_id');
    }

    public function trash() {
        return $this->hasMany('Lvmod\ControlPanel\Models\MultimediaTrash', 'type_id');
    }

}
