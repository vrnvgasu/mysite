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
        }

        $this->output();
    }

    // выводим код html
    protected function output()
    {
        echo $this->menuHtml;
    }

    // формируем само дерево из ассоциативного массива
    protected function getTree()
    {

    }

    // получаем html код ($tab разделитель - нужен в админке)
    protected function getMenuHtml($tree, $tab = '')
    {

    }

    protected function catToTemplate($category, $tab, $id)
    {

    }
}