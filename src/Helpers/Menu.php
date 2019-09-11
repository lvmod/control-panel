<?php

namespace Lvmod\ControlPanel\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Menu {

    // protected $menu;
    
    // public function __construct($menu) {
    //     $this->menu = $menu;
    // }

    public static function get() {
        $menu = DB::table('menu')->get();
        return Menu::build($menu);
    }

    private static function build($menu, $root = null) {
        $result = [];
        if(!$menu || !count($menu)) {
            return $result;
        }

        foreach($menu as $key => $item) {
            if($item->parent_id == $root) {
                unset($menu[$key]);
                $result[] = [
                    'item' => $item,
                    'children' => Menu::build($menu, $item->id)
                ];
            }
        }
        return $result;    
    }
}