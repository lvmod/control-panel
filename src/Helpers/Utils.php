<?php

namespace Lvmod\ControlPanel\Helpers;

use Illuminate\Support\Facades\DB;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class Utils
{

    protected $disk;
    protected $root;
    protected $materialsPath;
    protected $uploadfiles;

    public function __construct()
    { 
        $this->disk = config('controlpanel.media.disk');
        $this->root = config('controlpanel.media.root');
        $this->materialsPath = config('controlpanel.media.materialsPath');
        $this->uploadfiles = config('controlpanel.media.uploadfiles');
    }
    /**
     * Возвращает массив options для элемента отображения выпадающего списка
     * @param array $arr входящий массив
     * @param string $keyColumn имя колонки содержащей ключи
     * @param string $valueColumns имя колонки содержащей значения
     * @return array
     */
    public function getOptionsForFormSelect($arr, $keyColumn, $valueColumns, $separator = " ")
    {
        if (is_null($arr) || is_null($keyColumn) || is_null($valueColumns)) {
            return array();
        }

        $result = array();
        foreach ($arr as $item) {
            if (isset($item[$keyColumn])) {
                if (is_array($valueColumns)) {
                    foreach ($valueColumns as $valueColumn) {
                        if (is_array($valueColumn)) {
                            if (isset($valueColumn['column']) && !empty($valueColumn['column']) && isset($item[$valueColumn['column']])) {
                                $val = $item[$valueColumn['column']];
                                $left = isset($valueColumn['left']) ? $valueColumn['left'] : '';
                                $right = isset($valueColumn['right']) ? $valueColumn['right'] : '';
                                if (!isset($result[$item[$keyColumn]])) {
                                    $result[$item[$keyColumn]] = $left . $val . $right;
                                } else {
                                    $result[$item[$keyColumn]] .= $separator . $left . $val . $right;
                                }
                            }
                        } else {
                            if (isset($item[$valueColumn])) {
                                if (!isset($result[$item[$keyColumn]])) {
                                    $result[$item[$keyColumn]] = $item[$valueColumn];
                                } else {
                                    $result[$item[$keyColumn]] .= $separator . $item[$valueColumn];
                                }
                            }
                        }
                    }
                } else {
                    if (isset($item[$valueColumns])) {
                        $result[$item[$keyColumn]] = $item[$valueColumns];
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Возвращает последнюю добавленную запись
     * @param array $arr входящий массив
     * @param string $idColumn имя колонки содержащей идентификаторы
     * @return array последняя добавленнаа запись
     */
    public function getLastInserted($arr, $idColumn = 'id')
    {
        $last = 0;
        $result = array();
        if (is_null($arr)) {
            return $result;
        }

        foreach ($arr as $item) {
            if (!empty($item[$idColumn]) && $last < $item[$idColumn]) {
                $last = $item[$idColumn];
                $result = $item;
            }
        }

        return $result;
    }

    /**
     * Возвращает список пользователей для элемента отображения выпадающего списка  
     * @return array
     */
    public function getAllowRoleList($identity)
    {

        $role = 'guest';

        if (!empty($identity->role)) {
            $role = $identity->role;
        }

        $result = array(
            //            'guest' => 'Гость',
            'customer' => 'Пользователь',
            'admin' => 'Администратор',
            'developer' => 'Разработчик'
        );

        switch ($role) {
            case 'guest':
                unset($result['customer']);
            case 'customer':
                unset($result['admin']);
            case 'admin':
                unset($result['developer']);
                break;
            case 'developer':
                break;
            default:
                unset($result['customer']);
                unset($result['admin']);
                unset($result['developer']);
                break;
        }
        return $result;
    }

    public function generateString($length = 7)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789!@#$%^&+-*/()_.\{}[]?<>,|';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    /**
     * Генерация миниатюры
     * @param string $src имя исходного файла
     * @param string $dest имя генерируемого файла
     * @param int $width ширина генерируемого изображения, в пикселях
     * @param int $height высота генерируемого изображения, в пикселях
     * @param int $rgb цвет фона, по умолчанию - белый
     * @param int $quality качество генерируемого JPEG, по умолчанию - максимальное (100)
     * @return boolean
     */
    public function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
    {
        if (!file_exists($src))
            return false;

        $size = getimagesize($src);

        if ($size === false)
            return false;

        // Определяем исходный формат по MIME-информации, предоставленной
        // функцией getimagesize, и выбираем соответствующую формату
        // imagecreatefrom-функцию.
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = "imagecreatefrom" . $format;
        if (!function_exists($icfunc))
            return false;

        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];

        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);

        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

        imagejpeg($idest, $dest, $quality);

        imagedestroy($isrc);
        imagedestroy($idest);

        return true;
    }

    public function getFullYears($birthdayDate)
    {
        $datetime = new \DateTime($birthdayDate);
        $interval = $datetime->diff(new \DateTime(date("Y-m-d")));
        return $interval->format("%Y");
    }

    public function startsWith($str, $substr)
    {
        // search backwards starting from haystack length characters from the end
        return $substr === "" || mb_strrpos($str, $substr, -mb_strlen($str, 'UTF-8'), 'UTF-8') !== FALSE;
    }

    public function endsWith($str, $substr)
    {
        // search forward starting from end minus needle length characters
        return $substr === "" || (($temp = mb_strlen($str, 'UTF-8') - mb_strlen($substr, 'UTF-8')) >= 0 && mb_strpos($str, $substr, $temp, 'UTF-8') !== FALSE);
    }

    /**
     * Преобразование $data в требуемую кодировку
     * @param string $in_charset кодировка входной строки
     * @param string $out_charset требуемая на выходе кодировка
     * @param string|array|object $data данные подлежащие преобразованию
     * @return преобразованные данные
     */
    public function extIconv($in_charset, $out_charset, $data)
    {
        if (is_array($data)) {
            foreach ($data as &$val) {
                $val = $this->extIconv($in_charset, $out_charset, $val);
            }
            return $data;
        } else if (is_string($data)) {
            return iconv($in_charset, $out_charset, $data);
        }

        return $data;
    }

    /**
     * Возвращает максимально допустимый размер файла для загрузки
     */
    public function fileUploadMaxSize()
    {
        static $max_size = -1;

        if ($max_size < 0) {

            $post_max_size = $this->parseSize(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            $upload_max = $this->parseSize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                return ini_get('upload_max_filesize');
            } else {
                return ini_get('post_max_size');
            }
        }
        return -1;
    }

    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public function getPaginatorLinks($pageNumber, $totalCount, $showCount) {
        $middle = intval($showCount / 2);

        //Левая граница
        $left = $pageNumber - $middle;
        //Правая граница
        $right = $pageNumber + $middle;

        //Определяем на сколько правая граница выходит за пределы количества элементов
        $rtc = $right - $totalCount;
        if ($rtc > 0) {
            //Корректируем левую границу
            $left -= $rtc;
            //Корректируем правую границу
            $right = $totalCount;
        }

        //Определяем на сколько левая граница меньше 1
        $ltc = 1 + $left;
        if ($ltc <= 1) {
            //Корректируем правую границу
            $right += 1 + abs($left);
            if ($right > $totalCount) {
                $right = $totalCount;
            }
            //Корректируем левую границу
            $left = 1;
        }

        return [
            'start' => $left, 
            'end' => $right, 
            'pageNumber'=> $pageNumber,
            'showCount'=> $showCount,
            'totalCount'=> $totalCount
        ];
    }

    /**
     * Удаление неиспользуемого материала
     */
    public function deleteNotUseMaterials($material_type, $material_id, $material_body, $anotherFiles=[]) {
        try {
            $crawler = new Crawler($material_body);
            $srcList = ($crawler->filter('img[src]')->each(function ($node) {
                $path = $node->attr('src');
                if ($path) {
                    return $path;
                }
                return;
            }));

            $srcList = array_merge($srcList, $anotherFiles);
            $indoc = [];
            foreach ($srcList as $value) {
                if ($value) {
                    $n = basename($value);
                    $indoc[$n] = $n;
                }
            }
            $files = Storage::disk($this->disk)->files($this->materialsPath . '/' . $material_type . '/' . $material_id);
            foreach ($files as $file) {
                if (!array_key_exists(basename($file), $indoc)) {
                    Storage::disk($this->disk)->delete($file);
                }
            }
        } catch (\Exception $ex) {
            //throw $th;
        }
    }

    /**
     * Удаление папки материала
     */
    public function deleteMaterialsFolder($material_type, $material_id) {
        try {
            Storage::disk($this->disk)->deleteDirectory($this->materialsPath . '/' . $material_type . '/' . $material_id);
        } catch (\Exception $ex) {
            //throw $th;
        }
    }    

    public function basePath() {
        return '/'.$this->root.'/' . $this->uploadfiles;
    }

}
