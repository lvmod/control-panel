<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Multimedia;
use Lvmod\ControlPanel\Models\MultimediaType;
use Lvmod\ControlPanel\Repositories\MultimediaRepository;
use Lvmod\ControlPanel\Repositories\MultimediaTypeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    protected $uploadMaxFilesize = "200MB";
    protected $photopeople = "images/people";
    protected $uploadfiles = "files/multimedia";

    /**
     * @var MultimediaRepository
     */
    protected $media;

    /**
     * @var MultimediaTypeRepository
     */
    protected $mediaType;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MultimediaRepository $media, MultimediaTypeRepository $mediaType)
    {
        $this->media = $media;
        $this->mediaType = $mediaType;
    }

    public function index(Request $request)
    {
        return view('control::multimedia.index');
    }

    public function view(Request $request, $id)
    {
        if (!$id) {
            $id = 0;
        }

        $current = $this->media->byId($id);
        $files = $this->media->byParent($id);

        //Добавляем переход к предыдущей папке
        // error_log($files);
        if ($current && $current->isfolder) {

            $foder_default_preview = $current->type->default_preview;
            if ($current->parent && $current->parent->type && $current->parent->type->default_preview) {
                $foder_default_preview = $current->parent->type->default_preview;
            }
            if (!$foder_default_preview) {
                $foder_default_preview = '/images/PNG/Documents/Grey/Stroke/@2x/icon-95-folder@2x.png';
            }

            $pseudoFolder = new Multimedia();
            $pseudoFolder->id = $current->parent_id;
            $pseudoFolder->name = '..';
            $pseudoFolder->file_name = '..';
            $pseudoFolder->type = $current->type;
            $pseudoFolder->isfolder = 1;
            $pseudoFolder->external_url = '';
            $pseudoFolder->description = '';
            $pseudoFolder->type_id = $current->type->id;
            $pseudoFolder->type_name = 'folder';
            $pseudoFolder->type_makepreview = 0;
            $pseudoFolder->type_display = 0;
            $pseudoFolder->default_preview = $foder_default_preview;

            $files->prepend($pseudoFolder);
        }

        return [
            'files' => $files,
            'id' => $id,
            'mediaType' => $this->mediaType->allExtension(),
            'filePath' => $this->uploadfiles . "/",
            'filePathMin' => $this->uploadfiles . "_min/",
            'uploadMaxFilesize' => $this->uploadMaxFilesize,
            'path' => $this->media->getPathById($id),
        ];
    }

    public function newfolder(Request $request)
    {
        $data = json_decode($request->getContent());
        if (!$data->name) {
            return ['error' => 'Имя папки не может быть пустым'];
        }
        $name = trim($data->name);
        if ($name === '.' || $name === '..') {
            return ['error' => 'Недопустимое имя папки'];
        }

        $parent = $data->parent;
        if (!$parent) {
            $parent = 0;
        }

        if ($this->media->byName($name, $parent)) {
            return ['error' => 'Папка с таким именем уже существует'];
        }

        $folder = new Multimedia();
        $folder->parent_id = $parent;
        $folder->name = $name;
        $folder->type_id = 1;
        $folder->isfolder = 1;
        $folder->save();
        $folder->type;
        return $folder;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'posted' => 'required',
            'category' => 'required',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $news = new News;
        $news->title = $request->title;
        $news->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $news->visible = !!$request->visible;
        $news->body = $request->body;
        $news->author_id = $request->user()->id;
        $news->category_id = $request->category;
        $news->save();

        return redirect('/control/news');
    }

    public function update(Request $request, News $news)
    {
        $this->validate($request, [
            'posted' => 'required',
            'category' => 'required',
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $news->title = $request->title;
        $news->posted = \Carbon\Carbon::parse($request->posted)->toDateString();
        $news->visible = !!$request->visible;
        $news->body = $request->body;
        $news->author_id = $request->user()->id;
        $news->category_id = $request->category;
        $news->save();

        return redirect('/control/news');
    }

    public function delete(Request $request, News $news)
    {
        $news->delete();
        return redirect('/control/news');
    }
}
