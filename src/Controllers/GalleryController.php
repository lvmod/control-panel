<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Gallery;
use Lvmod\ControlPanel\Repositories\GalleryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    protected $filePath;

    /**
     *
     * @var GalleryRepository
     */
    protected $gallery;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GalleryRepository $gallery)
    {
        $this->gallery = $gallery;
        $this->filePath = '/'.config('controlpanel.media.root').'/'.config('controlpanel.media.uploadfiles');
    }

    public function index(Request $request, $type)
    {
        return view('control::gallery.index', [
            'type' => $type,
            'gallery' => $this->gallery->findPaginate($type),
            'filePath' => $this->filePath,
        ]);
    }

    public function view(Request $request, Gallery $gallery)
    {
        return view('control::gallery.view', [
            'gallery' => $gallery,
            'filePath' => $this->filePath,
        ]);
    }

    public function create(Request $request, $type)
    {
        return view('control::gallery.create', [
            'type' => $type,
        ]);
    }

    public function edit(Request $request, Gallery $gallery)
    {
        return view('control::gallery.edit', [
                'gallery' => $gallery,
                'filePath' => $this->filePath,
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'title' => 'required|max:255',
                'type' => 'required|max:255'
            ]
        );
        $gallery = new Gallery;
        $gallery->type = $request->type;
        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->save();

        return redirect('/control/gallery/edit/'.$gallery->id);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->validate($request, [
                'title' => 'required|max:255'
            ]
        );

        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->save();

        return redirect('/control/gallery/'.$gallery->type);
    }

    public function delete(Request $request, Gallery $gallery)
    {
        $gallery->delete();
        return redirect('/control/gallery/'.$gallery->type);
    }

    public function apiGetAllFiles(Request $request, Gallery $gallery)
    {
        // $gallery->multimedia()->orderBy
        return $gallery->multimedia;
    }

    public function apiStore(Request $request, Gallery $gallery)
    {
        $data = json_decode($request->getContent());
        // return $data;
        if (!$data || !is_array($data) || !count($data)) {
            return ['error' => 'Ошибка добавления файлов в галерею'];
        }

        //Вычисляем максимальный order
        $existMultimedia = [];       
        $maxSort = 0;
        foreach ($gallery->multimedia as $item) {
            $existMultimedia[$item->pivot->multimedia_id] = $item;
            if($maxSort < $item->pivot->sort) {
                $maxSort = $item->pivot->sort;
            }
        }

        $attachData = [];
        foreach ($data as $value) {
            if(!array_key_exists($value, $existMultimedia)) {
                $maxSort++;
                $attachData[$value] = ["sort" => $maxSort];
            }
        }

        $gallery->multimedia()->attach($attachData);

        return $gallery->multimedia()->get();
    }

    public function apiSetSort(Request $request, Gallery $gallery, $multimediaId, $multimediaSort)
    {
        if(!$gallery || !$multimediaId) {
            return ['error' => 'Ошибка перемещения'];
        }

        $gallery->multimedia()->updateExistingPivot($multimediaId, ["sort" => $multimediaSort]);
        return $gallery->multimedia;
    }

    public function apiDelete(Request $request, Gallery $gallery, $fileId)
    {
        $gallery->multimedia()->detach($fileId);
        return $gallery->multimedia;
    }
}
