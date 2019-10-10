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
        $this->filePath = '/'.config('controlpanel.media.root').'/'.config('controlpanel.media.uploadfiles').'/';
    }

    public function index(Request $request)
    {
        return view('control::gallery.index', [
            'gallery' => $this->gallery->findPaginate(),
        ]);
    }

    public function view(Request $request, Gallery $gallery)
    {
        return view('control::gallery.view', [
            'gallery' => $gallery,
        ]);
    }

    public function create(Request $request)
    {
        return view('control::gallery.create');
    }

    public function edit(Request $request, Gallery $gallery)
    {
        return view('control::gallery.edit', ['gallery' => $gallery]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'title' => 'required|max:255',
                'multimedia' => 'required',
            ], 
            [
                'multimedia.required' => 'Необходимо выбрать папку для галереи',
            ]
        );
        $gallery = new Gallery;
        $gallery->priority = $request->priority?:1;
        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->multimedia_id = $request->multimedia?$request->multimedia:null;
        $gallery->save();

        return redirect('/control/gallery/edit/'.$gallery->id);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->validate($request, [
                'title' => 'required|max:255',
                'multimedia' => 'required',
            ], 
            [
                'multimedia.required' => 'Необходимо выбрать папку для галереи',
            ]
        );

        $gallery->priority = $request->priority?:1;
        $gallery->title = $request->title;
        $gallery->author_id = $request->user()->id;
        $gallery->multimedia_id = $request->multimedia?$request->multimedia:null;
        $gallery->save();

        return redirect('/control/gallery');
    }

    public function delete(Request $request, Gallery $gallery)
    {
        $gallery->delete();
        return redirect('/control/gallery');
    }
}
