<?php

namespace Lvmod\ControlPanel\Helpers;
 
use Illuminate\Support\Facades\DB;
 
class Menu {

    protected $menu;
    protected $breadcrumb = []; 
    
    public function __construct() {
        $menu = DB::table('menu')->get();
        $this->menu = $this->build($menu);
    }

    public function get() {
        return $this->menu['children'];
    }

    public function breadcrumb() {
        return $this->breadcrumb;
    }

    private function build($menu, $root = null) {
        if(!$root) {
            $root = [
                'id' => null,
                'item' => null,
                'active' => false,
                'children' => []
            ];
        }

        if(!$menu || !count($menu)) {
            return $root;
        }

        foreach($menu as $key => $item) {
            if($item->parent_id == $root['id']) {
                unset($menu[$key]);
                $menuItem = $this->build($menu, [
                    'id' => $item->id,
                    'item' => $item,
                    'active' => '/'.\Request::path() == $item->path,
                    'children' => []
                ]);
                $root['children'][] = $menuItem;
                if($menuItem['active']) {
                    array_unshift($this->breadcrumb, $menuItem);
                    $root['active'] = true;
                }
            }
        }
        return $root;    
    }
}