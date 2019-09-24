<?php

namespace Lvmod\ControlPanel\Repositories;

use App\User;
use Lvmod\ControlPanel\Models\Multimedia;
use Lvmod\ControlPanel\Models\MultimediaTrash;
use Illuminate\Support\Facades\DB;

class MultimediaRepository
{


    /**
     * Получить все файлы.
     *
     * @return Collection
     */
    public function find()
    {
        return Multimedia::orderBy('isfolder', 'desc')->orderBy('name', 'asc')->get();
    }

    /**
     * Получить все файлы в папке.
     *
     * @param  int  $parent_id
     * @param  int  $fileTypes типы файлов из таблицы multimedia_type разделенные запятыми
     * @param  int  $viewer значение поля viewer из таблицы multimedia_type
     * @return Collection
     */
    public function byParent($parent_id, $fileTypes = '', $viewer = '')
    {
        $query = Multimedia::with('type')->where('parent_id', $parent_id);
        if (!empty($fileTypes)) {
            $fileTypes = "'" . str_replace(",", "','", $fileTypes) . "'";
            $query->whereHas("type", function ($query) use ($fileTypes) {
                $query->whereRaw("(name in (" . $fileTypes . ") or name = 'folder')");
            });
        } else if(!empty($viewer)) {
            $query->whereHas("type", function ($query) use ($viewer) {
                $query->whereRaw("(viewer = ? or name = 'folder')", $viewer);
            });
        }

        return $query->orderBy('isfolder', 'desc')->orderBy('name', 'asc')->get();
    }

    public function byId($id)
    {
        return Multimedia::with('type')->find($id);
    }

    public function byName($name, $parent_id = 0)
    {
        return Multimedia::where('parent_id', $parent_id)->where('name', $name)->with('type')->first();
    }

    /**
     * Возвращает путь к файлу от дериктории $rootId
     */
    public function getPathById($id = null, $rootId = 0)
    {
        $res = Multimedia::find($id);
        $path = [];

        if (!$res) {
            return $path;
        }

        if ($res->parent_id > 0 && $res->id != $rootId) {
            $path = array_merge($path, $this->getPathById($res->parent_id, $rootId));
        }
        $path[] = $res;

        return $path;
    }

    /**
     * Преобразовывает массив $path в строку
     * @param array $path
     * @return string
     */
    public function pathToString($path) {
        if (!is_null($path) && is_array($path) && count($path) > 0) {
            $res = "";
            foreach ($path as $item) {
                if (empty($item->name)) {
                    continue;
                }

                if (empty($res)) {
                    $res = $item->name;
                } else {
                    $res .= "/" . $item->name;
                }
            }

            return $res;
        }

        return "";
    }

    /**
     * Если $id - файл, то возвращает этот файл. Если $id - папка, 
     * то возвращает файлы и папки находящиеся в директории $id, 
     * так же обходит все вложенные папки
     * @param int $id идентификатор файла или папки
     * @param bool $isListResult если true то результат вернется в списке, иначе результат представляет иерархическую структуру
     * @param bool $showPath если true то в каждый элемент массива будет включаться полный путь к файлу
     * @param int $rootId передается в функцию getPathById для ограничения пути
     * @return array если $isListResult = false,
     * то результат будет иерархический массив вида: ('file'=>array(), 'path'=>array(), 'child'=>array()), 
     * иначе массив содержащий список файлов файлов [file, file, ...]. 
     * file - информация о файле;
     * path - виртуальный путь к файлу; 
     * child - массив элементов ('file'=>array(), 'path'=>array(), 'child'=>array())
     */
    public function getAllById($id, $isListResult = false, $showPath = false, $rootId = 0)
    {
        if (!isset($id) || is_null($id)) {
            return [];
        }

        $current = $this->byId($id);

        if (!$current || !$current->name) {
            return [];
        }

        if ($showPath) {
            $current->path = $this->pathToString($this->getPathById($current->id, $rootId));
        }

        $child = [];

        //Если папка
        if ($current->isfolder) {
            $dir = $this->byParent($id);
            if ($dir && count($dir)) {
                foreach ($dir as $item) {
                    $files = $this->getAllById($item->id, $isListResult, $showPath, $rootId);
                    if ($files && count($files)) {
                        if ($isListResult) {
                            $child = array_merge($child, $files);
                        } else {
                            $child[] = $files;
                        }
                    }
                }
            }
        }

        if ($isListResult) {
            $result = array_merge(array($current), $child);
        } else {
            $result = array('file' => $current, 'child' => $child);
            if ($showPath) {
                $result['path'] = $current->path;
            }
        }

        return $result;
    }

    public function trash($id)
    {
        if (!$id) {
            throw new Exception('Не удалось определить удаляемый объект');
        }

        try {
            DB::beginTransaction();
            $files = $this->getAllById($id, true);

            if ($files && count($files)) {
                foreach ($files as $file) {
                    if ($file && $file->id && $file->name) {
                        
                        MultimediaTrash::create([
                            'id' => $file->id,
                            'parent_id' => $file->parent_id,
                            'name' => $file->name,
                            'file_name' => $file->file_name,
                            'type_id' => $file->type_id,
                            'isfolder' => $file->isfolder,
                            'external_url' => $file->external_url,
                            'description' => $file->description,
                        ]);

                        $file->delete();
                        // Multimedia::destroy($file->id);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
