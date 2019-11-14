<?php


namespace app\models;


use ishop\App;

class Breadcrumbs
{
    //получаем сами хлебные крошки
    public static function getBreadcrumbs($category_id, $name = '')
    {
        // список категорий засунули в контейнер в AppController
        $cats = App::$app->getProperty('cats');
        $breadcrumbs_array = self::getParts($cats, $category_id);

        $breadcrumbs = "<li><a href='" . PATH . "'>Главная</a></li>";

        // ссылка на категорию
        if ($breadcrumbs_array) {
            foreach ($breadcrumbs_array as $alias => $title) {
                $breadcrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }

        //текущая страница
        if ($name) {
            $breadcrumbs .= "<li>{$name}</a></li>";
        }

        return $breadcrumbs;
    }

    public static function getParts($cats, $id)
    {
        if (!$id) return false;

        $breadcrumbs = [];

        // будем находится в цикле, пока будем строить хлебные крошки
        foreach ($cats as $k => $v) {
            if (isset($cats[$id])) {
                $breadcrumbs[$cats[$id]['alias']] = $cats[$id]['title'];
                $id = $cats[$id]['parent_id'];
            } else {
                break;
            }
        }

        return array_reverse($breadcrumbs,true);
    }
}