<?php


namespace ishop\base;


class Vie
{
    // Свойства, как и в контроллере
    // информация о текущем контроллере (массив: котроллер, экшн, префикс и тд)
    public $route;
    public $controler;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = []; // данные для view
    public $meta = []; // метаданные для view

    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controler = $route['controller'];
        $this->model = $route['controller'];   // имя модели совпадает с именем контроллера
        // для каждого вида создаем отдельную папку во app/views
        // в этих папках будем создавать файлы с именем экшена (его представление)
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;

        if ($layout === false) { // проверяем, что именно false, а не ''
            $this->layout = false;
        } else {
            // берем либо переданный шаблон, либо по умолчанию views/layouts/default.php
            $this->layout = $layout ? : LAYOUT;
        }
    }
}