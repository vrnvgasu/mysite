<?php


namespace ishop\base;


abstract class Controller
{
    // информация о текущем контроллере (массив: котроллер, экшн, префикс и тд)
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = []; // данные для view
    public $meta = [
        'title' => '',
        'desc' => '',
        'keywords' => '',
    ]; // метаданные для view

    public function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
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
        $this->meta['title'] = h($title);
        $this->meta['desc'] = h($desc);
        $this->meta['keywords'] = h($keywords);
    }

    /**
     * Метод из yii
     * True для асинхронного запроса
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Вернуть нужный вид
     * @param $view
     * @param array $vars
     */
    public function loadView($view, $vars = [])
    {
        extract($vars);
        require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
        die();
    }
}