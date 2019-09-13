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

}
