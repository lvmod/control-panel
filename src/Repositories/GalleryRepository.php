<?php

namespace Lvmod\ControlPanel\Repositories;

use Lvmod\ControlPanel\Models\Gallery;
use Illuminate\Pagination\Paginator;

class GalleryRepository {


    /**
     *
     * @return Collection
     */
    public function find() {
        return Gallery::with('author')->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
    }

    /**
     *
     * @return Collection
     */
    public function findPaginate($type) {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $gallery = Gallery::with('author');
        if($type) {
            $gallery = $gallery->where('type', $type);
        }
        $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        
        if($gallery->currentPage() > $gallery->lastPage()) {
            Paginator::currentPageResolver(function () use ($gallery) {
                return $gallery->lastPage();
            });
            $gallery = Gallery::with('author');
            if($type) {
                $gallery = $gallery->where('type', $type);
            }
            $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        } else if($gallery->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $gallery = Gallery::with('author');
            if($type) {
                $gallery = $gallery->where('type', $type);
            }
            $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        }
        return $gallery;
    }

     /**
     *
     * @return Collection
     */
    public function findPublicPaginate($type) {
        $count = app()->request->count?:15;
        if($count < 1 || $count > 200) {
            $count = 15;
        }
        $gallery = Gallery::with('author')->with('multimedia');
        if($type) {
            $gallery = $gallery->where('type', $type);
        }
        $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        if($gallery->currentPage() > $gallery->lastPage()) {
            Paginator::currentPageResolver(function () use ($gallery) {
                return $gallery->lastPage();
            });
            $gallery = Gallery::with('author')->with('multimedia');
            if($type) {
                $gallery = $gallery->where('type', $type);
            }
            $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        } else if($gallery->currentPage() < 1) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $gallery = Gallery::with('author')->with('multimedia');
            if($type) {
                $gallery = $gallery->where('type', $type);
            }
            $gallery = $gallery->orderBy('sort', 'asc')->orderBy('id', 'asc')->paginate($count)->appends(app()->request->query());
        }
        return $gallery;
    }


    // /**
    //  *
    //  * @return Collection
    //  */
    // public function findMultimediaByGallaryId($id) {
    //     return Gallery::with('author')->with('multimedia')->orderBy('pivot.sort', 'asc')->orderBy('pivot.id', 'asc')->get();
    // }

}
