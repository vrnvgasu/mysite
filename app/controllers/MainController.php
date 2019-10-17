<?php


namespace app\controllers;


use ishop\App;

class MainController extends AppController
{
    public function indexAction()
    {
        //debug($this->route);
        // App::$app->getProperty('shop_name') - параметры из регистра
        $this->setMeta(App::$app->getProperty('shop_name'), 'самая главная', 'круто супер главная');

        // Передаем данные в View
        $name = 'Дмитрий';
        $age = 30;
        $this->set(compact('name', 'age'));
    }
}