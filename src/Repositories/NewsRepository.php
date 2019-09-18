<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\News;
use Illuminate\Pagination\Paginator;

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
        $news = News::with('author')->with('category')->orderBy('posted', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($news->currentPage() > $news->total()) {
            Paginator::currentPageResolver(function () use ($news) {
                return $news->total();
            });
            $news = News::with('author')->with('category')->orderBy('posted', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($news->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = News::with('author')->with('category')->orderBy('posted', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $news;
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
