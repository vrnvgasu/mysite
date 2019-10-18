<?php


namespace app\controllers;


use ishop\App;
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
        $this->set(compact('name', 'age', 'posts'));
    }
}