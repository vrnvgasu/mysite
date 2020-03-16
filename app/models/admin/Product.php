<?php


namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel
{
    public $attributes = [
        'title' => '',
        'category_id' => '',
        'keywords' => '',
        'description' => '',
        'price' => '',
        'old_price' => '',
        'content' => '',
        'status' => '',
        'hit' => '',
        'alias' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
            ['category_id'],
            ['price'],
        ],
        'integer' => [
            ['category_id']
        ]
    ];

    // редактируем связанные продукты
    public function editRelatedProduct($id, $data)
    {
        $related_product = R::getCol('SELECT related_id FROM related_product ' .
            'WHERE product_id = ?', [$id]);

        // если data с фильтрами пустая, то удаляем для этого товара все связанные товары
        if (empty($data['related']) && !empty($related_product)) {
            R::exec("DELETE FROM related_product " .
                "WHERE product_id = ?", [$id]);
            return;
        }

        // если добавляем связанные товары
        if (empty($related_product) && !empty($data['related'])) {
            $sql_part = '';
            foreach ($data['related'] as $v) {
                $v = (int)$v;
                $sql_part .= "($id, $v),";
            }
            $sql_part = rtrim($sql_part, ',');

            // добавляем атрибуты для продукта из data
            R::exec("INSERT INTO related_product " .
                "(product_id, related_id) VALUES $sql_part");

            return;
        }

        // если изменил связанные товары - удалим старые и запишем новые
        if (!empty($data['attrs'])) {
            // вернет разницу массивов в виде массива
            $result = array_diff($related_product, $data['related']);

            if (!empty($result) ||
                count($related_product) != count($data['related'])) {
                R::exec("DELETE FROM related_product " .
                    "WHERE product_id = ?", [$id]);

                $sql_part = '';
                foreach ($data['related'] as $v) {
                    $v = (int)$v;
                    $sql_part .= "($id, $v),";
                }
                $sql_part = rtrim($sql_part, ',');

                // добавляем связанные товары для продукта из data
                R::exec("INSERT INTO related_product " .
                    "(product_id, related_id) VALUES $sql_part");
            }
        }
    }

    /**
     * data
     * Array
    (
    [title] => Salesforce
    [category_id] => 3
    [keywords] => 11
    [description] => Fork from https://javascript.info/type-conversions#tostring
    [price] => 3
    [old_price] => 11
    [content] =>123123123
    [status] => on
    [hit] => on
    [attrs] => Array
    (
    [1] => 1
    [2] => 3
    [3] => 5
    [4] => 7
    [5] => 9
    )
    )
     */
    // редактируем атрибуты
    public function editFilter($id, $data) {
        $filter = R::getCol('SELECT attr_id FROM attribute_product ' .
            'WHERE product_id = ?', [$id]);

        // если data с фильтрами пустая, то удаляем для этого товара все атрибуты
        if (empty($data['attrs']) && !empty($filter)) {
            R::exec("DELETE FROM attribute_product " .
                "WHERE product_id = ?", [$id]);
            return;
        }

        // если добавляем фильтры
        if (empty($filter) && !empty($data['attrs'])) {
            $sql_part = '';
            foreach ($data['attrs'] as $v) {
                $sql_part .= "($v, $id),";
            }
            $sql_part = rtrim($sql_part, ',');

            // добавляем атрибуты для продукта из data
            R::exec("INSERT INTO attribute_product " .
                "(attr_id, product_id) VALUES $sql_part");

            return;
        }

        // если измениль фильтры - удалим старые и запишем новые
        if (!empty($data['attrs'])) {
            // вернет разницу массивов в виде массива
            $result = array_diff($filter, $data['attrs']);

            if (!empty($result) || count($filter) != count($data['attrs'])) {
                R::exec("DELETE FROM attribute_product " .
                    "WHERE product_id = ?", [$id]);

                $sql_part = '';
                foreach ($data['attrs'] as $v) {
                    $sql_part .= "($v, $id),";
                }
                $sql_part = rtrim($sql_part, ',');

                // добавляем атрибуты для продукта из data
                R::exec("INSERT INTO attribute_product " .
                    "(attr_id, product_id) VALUES $sql_part");
            }
        }
    }

    public function getImg()
    {
        if (!empty($_SESSION['single'])) {
            $this->attributes['img'] = $_SESSION['single'];
            unset($_SESSION['single']);
        }
    }

    public function saveGallery($id)
    {
        if (!empty($_SESSION['multi'])) {
            $sql_part = '';

            foreach ($_SESSION['multi'] as $v) {
                $sql_part .= "('$v', $id),";
            }

            $sql_part = rtrim($sql_part, ',');
            R::exec("INSERT INTO gallery (img, product_id) VALUES $sql_part");
        }

        unset($_SESSION['multi']);
    }

    public function uploadImg($name, $wmax, $hmax)
    {
        $uploaddir = WWW . '/images/';

        if (!file_exists($uploaddir)) {
            mkdir($uploaddir);
        }

        $ext = strtolower(preg_replace(
            "#.+\.([a-z]+)$#i",
            "$1",
            $_FILES[$name]['name']
        )); // расширение
        $types = ["image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"];

        if ($_FILES[$name]['size'] > 1048576) {
            $res = ["error" => "Ошибка! Максимальный вес файла - 1 Мб!"];
            exit(json_encode($res));
        }

        if ($_FILES[$name]['error']) {
            $res = ["error" => "Ошибка! Возможно файл слишком большой."];
            exit(json_encode($res));
        }

        if (!in_array($_FILES[$name]['type'], $types)) {
            $res = ["error" => "Допустимые расширения - .gif, .jpg, .png"];
            exit(json_encode($res));
        }

        $new_name = md5(time()) . ".$ext";
        $uploadfile = $uploaddir.$new_name;

        if (@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
            if ($name == 'single') {
                $_SESSION['single'] = $new_name;
            } else {
                $_SESSION['multi'][] = $new_name;
            }

            static::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = ["file" => $new_name];
            exit(json_encode($res)); // выводим имя файла
        }
    }

    public static function resize($target, $dest, $wmax, $hmax, $ext)
    {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig;

        if (($wmax / $hmax) > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }

        $img = '';

        switch ($ext) {
            case 'gif':
                $img = imagecreatefromgif($target);
                break;
            case 'png':
                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }

        $newImg = imagecreatetruecolor($wmax, $hmax); // оболочка для новой картинки

        if ($ext == 'png') {
            imagesavealpha($newImg, true); // сохранение альфа канала
            // добавляем прозрачность
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefill($newImg, 0, 0, $transPng); // заливка
        }

        // копируем и ресйзим изображение
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);

        switch ($ext) {
            case 'gif':
                imagegif($newImg, $dest);
                break;
            case 'png':
                imagepng($newImg, $dest);
        }

        imagedestroy($newImg);
    }
}
