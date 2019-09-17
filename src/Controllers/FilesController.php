<?php

namespace Lvmod\ControlPanel\Controllers;

use Lvmod\ControlPanel\Models\Multimedia;
use Lvmod\ControlPanel\Models\MultimediaType;
use Lvmod\ControlPanel\Repositories\MultimediaRepository;
use Lvmod\ControlPanel\Repositories\MultimediaTypeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FilesController extends Controller
{
    protected $photopeople = "images/people";
    protected $disk = "media";
    protected $uploadfiles = "multimedia";

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
            'filePath' => '/files/'.$this->uploadfiles . "/",
            'filePathMin' => '/files/'.$this->uploadfiles . "_min/",
            'uploadMaxFilesize' => app()->Utils->fileUploadMaxSize(),
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

    public function download(Request $request, Multimedia $file)
    {
        if (!$file->isfolder) {
            if (!empty($file->file_name)) {
                $filePath = $this->uploadfiles . "/" . $file->file_name;
                if (Storage::disk($this->disk)->exists($filePath)) {

                    if (!empty($file->type->name) && !app()->Utils->endsWith(mb_strtolower($file->name, 'UTF-8'), mb_strtolower($file->type->name, 'UTF-8'))) {
                        $file->name .= '.' . $file->type->name;
                    }

                    return Storage::disk($this->disk)->download($filePath, $file->name);
                }
            }
        } else {
            //Создание временной папки
            $tmpDir = '/tmp/';
            Storage::disk($this->disk)->makeDirectory($tmpDir, $mode=0775);
            $path = Storage::disk($this->disk)->path($tmpDir);
            //Получаем список файлов
            $files = $this->media->getAllById($file->id, true, true, $file->id);

            //Создаем архив
            $fileName = $path . md5(date('Y-m-d H:i:s') . app()->Utils->generateString()) . '.zip';
            $zip = new ZipArchive();

            if ($zip->open($fileName, ZipArchive::CREATE) !== TRUE) {
                return ["result" => "error", "error" => "Во время создания архива произошла ошибка"];
            }

            $filePath = $this->uploadfiles . "/";
            
            if (!is_null($files) && is_array($files)) {
                foreach ($files as $item) {
                    if (!$item->isfolder && Storage::disk($this->disk)->exists($filePath . $item['file_name'])) {
                        if (!empty($item->type->name) && !app()->Utils->endsWith(mb_strtolower($item->name, 'UTF-8'), mb_strtolower($item->type->name, 'UTF-8'))) {
                            $item['name'] .= '.' . $item->type->name;
                        }
            
                        $zip->addFromString($item->path, Storage::disk($this->disk)->get($filePath . $item['file_name']));
                        // $zip->addFile( $path . '/public/' . $filePath . $item->file_name, iconv("UTF-8", "CP866", $item->path . $item->name));
                    } else if ($item['isfolder']) {
                        $zip->addEmptyDir($item->path);
                    }
                }
            }
            $zip->close();

            if ($zip->status != ZipArchive::ER_OK) {
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
                return ["result" => "error", "error" => "Во время создания архива произошла ошибка"];
            }

            $response = response(file_get_contents($fileName))
                ->header('Content-Type', 'application/file')
                ->header('content-length', filesize($fileName))
                ->header('content-Description', 'File Transfer')
                ->header('Content-Disposition', 'attachment; filename="' . $file['name'] . '.zip"');

            if (file_exists($fileName)) {
                unlink($fileName);
            }

            return $response;
        }

        abort(404);
    }

    public function upload(Request $request, $id)
    {
        if (!$id) {
            $id = 0;
        }

        // Storage::disk('local')->put('avatars/1', "asdfasdf");
        // var_dump(Storage::disk('local')->exists('avatars/1'));
        // var_dump(Storage::disk('local')->get('avatars/1'));
        // var_dump(Storage::disk('local')->url('avatars/1'));
        // Storage::size('file1.jpg');
        // Storage::lastModified('file1.jpg');
        // Storage::delete('file.jpg');
        // Storage::delete(['file1.jpg', 'file2.jpg']);
        // Storage::makeDirectory($directory);
        // Storage::deleteDirectory($directory);
        try {
            $file = $request->file('file');
            if (!$file || !$file->getClientOriginalName()) {
                return ['message' => 'Файл не выбран либо превышает допустимые ограничения по размеру'];
            }

            if ($this->media->byName($file->getClientOriginalName(), $id)) {
                return ['message' => 'Файл с таким именем уже существует'];
            }


            $type = $this->mediaType->getTypeByFileName($file->getClientOriginalName());

            if (!$type) {
                return ['message' => 'Ошибка загрузки файла. Не поддерживаемый тип файла'];
            }

            $name = $file->getClientOriginalName();
            $newName = md5(date('Y-m-d H:i:s')) . "_" . $name;
            Storage::disk($this->disk)->putFileAs($this->uploadfiles, $file, $newName);

            $path = Storage::disk($this->disk)->path($this->uploadfiles);
            $newFullName = $path . "/" . $newName;
            $newFullNameMin = $path . "_min/" . $newName;

            if ($type && $type->makepreview) {
                if(!Storage::disk($this->disk)->exists($this->uploadfiles."_min")) {
                   Storage::disk($this->disk)->makeDirectory($this->uploadfiles."_min", $mode=0775);
                }
                //Подобрать параметры ширины и высоты миниатюры
                app()->Utils->img_resize($newFullName, $newFullNameMin, 200, 100);
            }

            //Сохранение информации о файле в базе дынных
            $f = new Multimedia();
            $f->parent_id = $id;
            $f->name = $name;
            $f->file_name = $newName;
            $f->type_id = $type->id;
            $f->isfolder = 0;
            $f->save();
        } catch (\Exception $ex) {
            return ['message' => 'Произошла ошибка во время загрузки файла. Возможно файл превышает допустимые ограничения по размеру ' . app()->Utils->fileUploadMaxSize()];
        }

        return [];
    }

    public function delete(Request $request, $id)
    {
        if (!$this->media->trash($id)) {
            return ['error' => 'Ошибка удаления'];
        }
        return [];
    }

    public function links(Request $request, Multimedia $file)
    {
        $data = json_decode($request->getContent());
        if (!$data) {
            return ['error' => 'Ошибка установки связи'];
        }

        $file->users()->sync($data->users);

        return $file;
    }
}
