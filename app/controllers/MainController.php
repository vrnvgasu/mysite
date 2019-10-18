<?php


namespace app\controllers;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta(App::$app->getProperty('shop_name'), 'самая главная', 'круто супер главная');

        // Передаем данные в View
        $posts = R::findAll('test'); // данные из базы через ORM
        $name = 'Дмитрий';
        $age = 30;

        $names = ['Сергей', 'Петр'];
        $cache = Cache::instance(); // создали или взяли объект кэша
        $cache->set('test', $names); // сохранили в него данные по ключу
        // получим файл tmp/cache/098f6bcd4621d373cade4e832627b4f6.txt
        // с содержимым a:2:{s:4:"data";a:2:{i:0;s:12:"Сергей";i:1;s:8:"Петр";}s:8:"end_time";i:1571414654;}


        $data = $cache->get('test');
        $cache->delete('test');
        debug($data);


        $this->set(compact('name', 'age', 'posts', 'names'));
    }
}