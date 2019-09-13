<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\Multimedia;

class MultimediaRepository {


    /**
     * Получить все файлы.
     *
     * @return Collection
     */
    public function find() {
        return Multimedia::all();
    }

     /**
     * Получить все файлы в папке.
     *
     * @param  int  $parent_id
     * @return Collection
     */
    public function byParent($parent_id, $fileTypes = 'jpg,str,doc') {
        $query = Multimedia::with('type')->where('parent_id', $parent_id);
        if (!empty($fileTypes)) {
            $fileTypes = "'" . str_replace(",", "','", $fileTypes) . "'";
            $query->whereHas("type", function($query) use($fileTypes) {
                $query->whereRaw("(name in (" . $fileTypes . ") or name = 'folder')");
            });
        }

        return $query->orderBy('name', 'asc')->get();
    }

    public function byId($id) {
        return Multimedia::with('type')->find($id);
    }

    public function byName($name, $parent_id = 0) {
        return Multimedia::where('parent_id', $parent_id)->where('name', $name)->with('type')->first();
    }

    public function getPathById($id = null) {
        $res = Multimedia::find($id);
        $path = [];

        if (!$res) {
            return $path;
        }

        if ($res->parent_id > 0) {
            $path = array_merge($path, $this->getPathById($res->parent_id));
        }
        $path[] = $res;

        return $path;
    }
}
