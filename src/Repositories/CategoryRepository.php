<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\Category;

class CategoryRepository {


    /**
     * Получить все новости.
     *
     * @return Collection
     */
    public function find() {
        return Category::orderBy('id', 'asc')->get();
    }
}
