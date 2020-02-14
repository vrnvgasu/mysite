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

            if (!empty($result)) {
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
}
