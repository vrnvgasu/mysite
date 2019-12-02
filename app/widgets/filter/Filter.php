<?php


namespace app\widgets\filter;


use ishop\Cache;
use RedBeanPHP\R;

class Filter
{
    public $groups;
    public $attrs;
    public $tpl;

    public function __construct()
    {
        $this->tpl = __DIR__ . '/filter_tpl.php';
        $this->run();
    }

    // рендерит страницу
    protected function run()
    {
        $cache = Cache::instance();

        // берем группы категорий из кэша
        // если там нет, то из базы и кэшируем
        $this->groups = $cache->get('filter_group');
        if (!$this->groups) {
            $this->groups = $this->getGroups();
            $cache->set('filter_group', $this->groups, 30);
        }

        // берем атрибуты категорий из кэша
        // если там нет, то из базы и кэшируем
        $this->attrs = $cache->get('filter_attrs');
        if (!$this->attrs) {
            $this->attrs = $this->getAttrs();
            $cache->set('filter_attrs', $this->attrs, 30);
        }

        // возвращаем из буфера
        $filters = $this->getHtml();
        echo $filters;
    }

    /*
    Array
    [1] => Механизм
    [2] => Стекло
    [3] => Ремешок
    [4] => Корпус
    [5] => Индикация
     */
    protected function getGroups()
    {
        return R::getAssoc('SELECT id, title FROM attribute_group');
    }

    /*
     [1] => Array       // группа - Механизм
        (
            [1] => Механика с автоподзаводом
            [2] => Механика с ручным заводом
        )

    [2] => Array        // группа - Стекло
        (
            [3] => Сапфировое
            [4] => Минеральное
        )
    ,,,
     */
    protected function getAttrs()
    {
        $data = R::getAssoc('SELECT * FROM attribute_value');
        $attrs = [];

        foreach ($data as $k => $v) {
            $attrs[$v['attr_group_id']][$k] = $v['value'];
        }

        return $attrs;
    }

    // получаем html код страницы
    protected function getHtml()
    {
        // все кладем в буфер
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}