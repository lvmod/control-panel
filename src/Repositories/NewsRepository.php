<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\News;

class NewsRepository {


    /**
     * Получить все новости.
     *
     * @return Collection
     */
    public function find() {
        return News::with('author')->with('category')->orderBy('posted', 'desc')->get();
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

        return News::with('author')->with('category')->orderBy('posted', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
    }

     /**
     * Получить все новости заданного пользователя.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user) {
        return $user->news()->with('category')
                        ->orderBy('created_at', 'asc')
                        ->get();
    }
}
