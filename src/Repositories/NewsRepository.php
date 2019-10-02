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
        return News::with('author')->with('category')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->get();
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
        $news = News::with('author')->with('category')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($news->currentPage() > $news->total()) {
            Paginator::currentPageResolver(function () use ($news) {
                return $news->total();
            });
            $news = News::with('author')->with('category')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($news->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = News::with('author')->with('category')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $news;
    }

        /**
     * Получить все новости.
     *
     * @return Collection
     */
    public function findPublicPaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $news = News::with('author')->with('category')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($news->currentPage() > $news->total()) {
            Paginator::currentPageResolver(function () use ($news) {
                return $news->total();
            });
            $news = News::with('author')->with('category')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($news->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = News::with('author')->with('category')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $news;
    }

    public function findFillBaseImagePaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $news = News::with('author')->with('category')->with('multimedia')->
        where(function($q) {
            $q->whereNotNull('multimedia_id')
              ->orWhereNotNull('image');
        })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($news->currentPage() > $news->total()) {
            Paginator::currentPageResolver(function () use ($news) {
                return $news->total();
            });
            $news = News::with('author')->with('category')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($news->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $news = News::with('author')->with('category')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
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
        return $user->news()->with('category')->with('multimedia')
                        ->orderBy('created_at', 'asc')->orderBy('id', 'desc')
                        ->get();
    }
}
