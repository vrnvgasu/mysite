<?php


namespace ishop\base;


abstract class Controller
{
    // информация о текущем контроллере (массив: котроллер, экшн, префикс и тд)
    public $route;
    public $controler;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = []; // данные для view
    public $meta = []; // метаданные для view

    public function __construct($route)
    {
        $this->route = $route;
        $this->controler = $route['controller'];
        $this->model = $route['controller'];   // имя модели совпадает с именем контроллера
        // для каждого вида создаем отдельную папку во app/views
        // в этих папках будем создавать файлы с именем экшена (его представление)
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }

    /**
     * Создаем страницу и получаем ее через view
     */
    public function getView() {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    /**
     * Записываем сюда данные и передаем в вид
     * @param $data
     */
    public function set($data)
    {
        $this->data = $data;
    }

    /**
     * Записываем сюда МетаДанные и передаем в вид
     * @param $data
     */
    public function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}