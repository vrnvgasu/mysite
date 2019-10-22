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
    }
}