<?php


namespace ishop\base;


class View
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

    /**
     * Формируем страницу для пользователя
     */
    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }

        // Получаем путь к странице нашего вида
        // /home/vagrant/project2/app/views/Main/index.php
        $viewFile = APP . "/views/{$this->prefix}{$this->controler}/{$this->view}.php";

        // Подключаем файл со страницей или кидаем ошибку
        if (is_file($viewFile)) {
            ob_start(); // включаем буферезацию, чтобы сразу не выводить страницу
            require_once $viewFile;
            // страница будет хранится в переменной $content
            $content = ob_get_clean(); // получаем буфер и очищаем его
        } else {
            throw new \Exception("Не найден вид {$viewFile}", 500);
        }

        $meta = $this->getMeta();

        // подключаем шаблон, если он есть
        if ($this->layout !== false) {
            // /home/vagrant/project2/app/views/layouts/default.php
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден шаблон {$this->layout}", 500);
            }
        }
    }

    public function getMeta()
    {
        /*$meta = '';
        if (isset($this->meta['title'])) {
            $meta .=
        }
        if (isset($this->meta['desc'])) {
            $meta .= "<meta name=\"description\" content=\"{$this->meta['desc']}\">";
        }
        if (isset($this->meta['keywords'])) {
            $meta .= "<meta http-equiv=\"Content-Type\" content=\"{$this->meta['keywords']}\"></title>";
        }

        return $meta;*/
        $output = "<title>{$this->meta['title']}</title>";
        $output .= "<meta name=\"description\" content=\"{$this->meta['desc']}\">";
        $output .= "<meta http-equiv=\"Content-Type\" content=\"{$this->meta['keywords']}\"></title>";

        return $output;
    }
}