<?php

namespace Lvmod\ControlPanel\Repositories;

use Lvmod\ControlPanel\Models\User;
use Lvmod\ControlPanel\Models\Article;
use Illuminate\Pagination\Paginator;

class ArticleRepository {
    /**
     *
     * @return Collection
     */
    public function find() {
        return Article::with('author')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->get();
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
        $article = Article::with('author')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        if($article->currentPage() > $article->lastPage()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->lastPage();
            });
            $article = Article::with('author')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = Article::with('author')->with('multimedia')->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
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
        $article = Article::with('author')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        if($article->currentPage() > $article->lastPage()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->lastPage();
            });
            $article = Article::with('author')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = Article::with('author')->with('multimedia')->where('visible', true)->where('posted', '<=', \Carbon\Carbon::today())->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        }
        return $article;
    }

    public function findFillBaseImagePaginate() {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $article = Article::with('author')->with('multimedia')->
        where(function($q) {
            $q->whereNotNull('multimedia_id')
              ->orWhereNotNull('image');
        })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        if($article->currentPage() > $article->lastPage()) {
            Paginator::currentPageResolver(function () use ($article) {
                return $article->lastPage();
            });
            $article = Article::with('author')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        } else if($article->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $article = Article::with('author')->with('multimedia')->
            where(function($q) {
                $q->whereNotNull('multimedia_id')
                  ->orWhereNotNull('image');
            })->orderBy('posted', 'desc')->orderBy('id', 'desc')->paginate($count)->appends(app()->request->query());
        }
        return $article;
    }

     /**
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user) {
        return $user->articles()->with('multimedia')
                        ->orderBy('created_at', 'asc')->orderBy('id', 'desc')
                        ->get();
    }
}
