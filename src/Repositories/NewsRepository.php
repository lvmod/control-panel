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
        return News::all();
    }

     /**
     * Получить все новости заданного пользователя.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user) {
        return $user->news()
                        ->orderBy('created_at', 'asc')
                        ->get();
    }

}
