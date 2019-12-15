<?php


namespace app\models;


use ishop\base\Model;
use RedBeanPHP\R;

class AppModel extends Model
{
    public static function createAlias($table, $field, $str, $id)
    {
        // далаем транслит
        $str = self::str2url($str);

        $res = R::findOne($table, "$field = ?", [$str]);

        if ($res) {
            // создаем алиас для записи
            $str = "{$str}-{$id}";

            // если такой алиас существует, то еще раз вызовем функцию
            $res = R::count($table, "$field = ?", [$str]);
            if ($res) {
                $str = self::createAlias($table, $field, $str, $id);
            }
        }

        return $str;
    }

    public static function str2url($str)
    {
        // переводим в транслит
        $str = self::rus2translic($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменяем все ненужно на на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");

        return $str;
    }

    public static function rus2translic($string)
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'u', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'v',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'ь' => '\'', 'Ы' => 'Y', 'ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        return strtr($string, $converter);
    }
}