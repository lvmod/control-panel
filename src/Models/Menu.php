<?php

namespace Lvmod\ControlPanel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model {

    public static $PLACE_TYPE_FIRST='first';
    public static $PLACE_TYPE_BEFORE='before';
    public static $PLACE_TYPE_INSTEAD='instead';
    public static $PLACE_TYPE_AFTER='after';
    public static $PLACE_TYPE_LAST='last';

    protected $table = 'menu';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [];

    public function parent() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\Menu');
    }

    public function place() {
        return $this->belongsTo('Lvmod\ControlPanel\Models\Menu');
    }

    public function items() {
        return $this->hasMany('Lvmod\ControlPanel\Models\Menu', 'parent_id');
    }
}
