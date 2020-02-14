<?php


namespace app\widgets\filter;


use ishop\Cache;
use RedBeanPHP\R;

class Filter
{
    public $groups;
    public $attrs;
    public $tpl;
    public $filter; // массив опций

    public function __construct($filter = null, $tpl = '')
    {
        $this->filter = $filter;
        $this->tpl = $tpl ?: __DIR__ . '/filter_tpl.php';
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
            $cache->set('filter_group', $this->groups);
        }

        // берем атрибуты категорий из кэша
        // если там нет, то из базы и кэшируем
        $this->attrs = $cache->get('filter_attrs');
        if (!$this->attrs) {
            $this->attrs = static::getAttrs();
            $cache->set('filter_attrs', $this->attrs);
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
    protected static function getAttrs()
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
        $filter = self::getFilter();
        if (!empty($filter)) {
            $filter = explode(',', $filter);
        }
        require $this->tpl;
        return ob_get_clean();
    }

    // обработать запрос из $_GET
    // только цифры и запятые
    public static function getFilter()
    {
        $filter = null;

        if (!empty($_GET['filter'])) {
            // заменить все пустой стокой кроме цифр и запятых
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }

        return $filter;
    }

    // кол-во выбранных категорий в фильтрах
    public static function getCountGroups($filter)
    {
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $attrs = $cache->get('filter_attrs');
        if (!$attrs) {
            $attrs = static::getAttrs();
        }

        $data = [];

        foreach ($attrs as $key => $item) {
            foreach ($item as $k => $v) {
                if (in_array($k, $filters)) {
                    $data[] = $key;
                    //break;
                }
            }
        }

        return count($data);
    }
}