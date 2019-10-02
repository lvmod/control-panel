<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\StaticArticle;
use Illuminate\Pagination\Paginator;

class StaticArticleRepository {
    /**
     *
     * @return Collection
     */
    public function find() {
        return StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->get();
    }

    /**
     *
     * @return Collection
     */
    public function findPaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $article = StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($article->currentPage() > $article->total()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->total();
            });
            $article = StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $article;
    }

        /**
     *
     * @return Collection
     */
    public function findPublicPaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $article = StaticArticle::with('author')->with('multimedia');
        if($article->currentPage() > $article->total()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->total();
            });
            $article = StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = StaticArticle::with('author')->with('multimedia')->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $article;
    }

    public function findFillBaseImagePaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $article = StaticArticle::with('author')->with('multimedia')->
        where(function($q) {
            $q->whereNotNull('multimedia_id')
              ->orWhereNotNull('image');
        })->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($article->currentPage() > $article->total()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->total();
            });
            $article = StaticArticle::with('author')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = StaticArticle::with('author')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('id', 'desc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $article;
    }

    public function byPath($path) {
        return StaticArticle::with('author')->with('multimedia')->where('path', $path)->first();
    }

     /**
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user) {
        return $user->staticArticles()->with('multimedia')
                        ->orderBy('created_at', 'asc')->orderBy('id', 'desc')
                        ->get();
    }
}
