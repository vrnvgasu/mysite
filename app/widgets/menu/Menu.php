<?php


namespace app\widgets\menu;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class Menu
{
    protected $data; // данные
    protected $tree; // массив дерева для данных
    protected $menuHtml; // готовый html код меню
    protected $tpl; // шаблон для меню
    protected $container = 'ul'; // в чем хранится меню
    protected $class = 'menu'; // кдасс контейнера
    protected $table = 'category'; // таблица БД для данных
    protected $cache = 3600; // время кэширования меню
    protected $cacheKey = 'ishop_menu'; // ключ кэша для меню
    protected $attrs = []; // атрибуты меню
    protected $prepend = ''; // для админки

    public function __construct($options = [])
    {
        // если в $options нет tpl, то берем по умолчанию
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';

        $this->getOptions($options); // передаем пользовательские настройки виджета
        $this->run(); // формируем меню
    }

    // передаем пользовательские настройки виджета
    protected function getOptions($options)
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    // получает меню и выводит его
    public function run()
    {
        $cache = Cache::instance();
        $this->menuHtml = $cache->get('ishop_menu');

        if (!$this->menuHtml) {
            // категории уже положили в контейнер в AppController
            $this->data = App::$app->getProperty('cats');

            // если что-то идет не так, еще раз возьмем
            if (!$this->data) {
                $this->data = R::getAssoc("SELECT * FROM category");
            }

            // получаем дерево для меню
            $this->tree = $this->getTree();
            // получаем код html меню
            $this->menuHtml = $this->getMenuHtml($this->tree);

            // кэшируем, если кэш задан в параметрах
            if ($this->cache) {
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
            }
        }

        $this->output();
    }

    // выводим код html
    protected function output()
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " {$k}='{$v}' ";
            }
        }

        echo "<{$this->container} class='{$this->class}' {$attrs}>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    // формируем само дерево из ассоциативного массива (id => запись категории из БД)
    protected function getTree()
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    // получаем html код ($tab разделитель - нужен в админке)
    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }

        return $str;
    }

    // делаем кусок кода меню html для каждой категории отдельно
    // и возвращаем код из буфера
    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;

        return ob_get_clean();
    }
}