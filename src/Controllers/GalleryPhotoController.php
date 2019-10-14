<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\GalleryPhoto;
use Lvmod\ControlPanel\Repositories\GalleryPhotoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryPhotoController extends Controller
{

    protected $filePath;

    /**
     *
     * @var GalleryPhotoRepository
     */
    protected $gallery;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GalleryPhotoRepository $gallery)
    {
        $this->gallery = $gallery;
        $this->filePath = '/'.config('controlpanel.media.root').'/'.config('controlpanel.media.uploadfiles');
    }

    public function index(Request $request)
    {
        return view('control::gallery.photo.index', [
            'gallery' => $this->gallery->findPaginate(),
            'filePath' => $this->filePath,
        ]);
    }

    public function view(Request $request, GalleryPhoto $gallery)
    {
        return view('control::gallery.photo.view', [
            'gallery' => $gallery,
            'filePath' => $this->filePath,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::gallery.photo.create');
    }

    public function edit(Request $request, GalleryPhoto $gallery)
    {
        return view('control::gallery.photo.edit', [
                'gallery' => $gallery,
                'filePath' => $this->filePath,
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'title' => 'required|max:255'
            ]
        );
        $gallery = new GalleryPhoto;
        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->save();

        return redirect('/control/gallery-photo/edit/'.$gallery->id);
    }

    public function update(Request $request, GalleryPhoto $gallery)
    {
        $this->validate($request, [
                'title' => 'required|max:255'
            ]
        );

        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->save();

        return redirect('/control/gallery-photo');
    }

    public function delete(Request $request, GalleryPhoto $gallery)
    {
        $gallery->delete();
        return redirect('/control/gallery-photo');
    }

    public function apiGetAllFiles(Request $request, GalleryPhoto $gallery)
    {
        // $gallery->multimedia()->orderBy
        return $gallery->multimedia;
    }

    public function apiStore(Request $request, GalleryPhoto $gallery)
    {
        $data = json_decode($request->getContent());
        // return $data;
        if (!$data) {
            return ['error' => 'Ошибка добавления файлов в галерею'];
        }

        $gallery->multimedia()->syncWithoutDetaching($data);

        return $gallery->multimedia;
    }

    public function apiDelete(Request $request, GalleryPhoto $gallery, $fileId)
    {
        $gallery->multimedia()->detach($fileId);
        return $gallery->multimedia;
    }
}
