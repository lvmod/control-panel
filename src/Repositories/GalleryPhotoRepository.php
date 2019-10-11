<?php

namespace Lvmod\ControlPanel\Repositories;

use Lvmod\ControlPanel\Models\GalleryPhoto;
use Illuminate\Pagination\Paginator;

class GalleryPhotoRepository {


    /**
     *
     * @return Collection
     */
    public function find() {
        return GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->get();
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
        $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($gallery->currentPage() > $gallery->total()) {
            Paginator::currentPageResolver(function () use ($gallery) {
                return $gallery->total();
            });
            $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($gallery->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $gallery;
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
        $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        if($gallery->currentPage() > $gallery->total()) {
            Paginator::currentPageResolver(function () use ($gallery) {
                return $gallery->total();
            });
            $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        } else if($gallery->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $gallery = GalleryPhoto::with('author')->orderBy('priority', 'desc')->orderBy('id', 'asc')->paginate($count)->appends(['count' => (app()->request->count)?$count:null]);
        }
        return $gallery;
    }

}
