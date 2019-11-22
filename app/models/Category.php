<?php


namespace app\models;


use ishop\App;

class Category extends AppModel
{
    // $id - текущая категория
    public function getIds($id)
    {
        //Массив всех категорий
        $cats = App::$app->getProperty('cats');

        $ids = null;

        // рекурсивно получим список id категорий начиная с детей
        // нашей категории и вниз по дереву
        // Так получили список всех вложенных категорий
        foreach ($cats as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }

        return $ids;
    }
}