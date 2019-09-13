<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultimediaTrash extends Model {

    protected $table = 'multimedia_trash';

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
}
