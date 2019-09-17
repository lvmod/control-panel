<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\MultimediaType;

class MultimediaTypeRepository {


    /**
     * @return Collection
     */
    public function find() {
        return MultimediaType::all();
    }

    public function byId($id) {
        return MultimediaType::find($id);
    }

    public function byName($name) {
        return MultimediaType::where('name', $name)->first();
    }

    public function allExtension() {
        return MultimediaType::where('name', '<>', 'folder')->orderBy('id', 'asc')->get();
    }

        /**
     * Возвращает тип по расширению в файле $fileName. 
     * Если тип не найден, возвращает пустой массив 
     * @param string $fileName имя файла
     * @return array
     */
    public function getTypeByFileName($fileName) {
        if (empty($fileName)) {
            return null;
        }

        $extList = $this->find();

        foreach ($extList as $item) {
            if (!empty($item->name)) {
                if (app()->Utils->endsWith(mb_strtoupper($fileName, 'UTF-8'), mb_strtoupper('.'.$item->name, 'UTF-8'))) {
                    return $item;
                }
            }
        }

        return null;
    }
}
