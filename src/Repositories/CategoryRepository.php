<?php

namespace Lvmod\ControlPanel\Repositories;

use Lvmod\ControlPanel\Models\User;
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

    /**
     * Получить все новости.
     *
     * @return Collection
     */
    public function findPaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $categoryQuery = Category::orderBy('id', 'desc');
        $query = $categoryQuery->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($query->currentPage() > $query->total()) {
            Paginator::currentPageResolver(function () use ($query) {
                return $query->total();
            });
            $query = $categoryQuery->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($query->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $query = $categoryQuery->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $query;
    }
}
