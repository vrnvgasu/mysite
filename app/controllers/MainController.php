<?php


namespace app\controllers;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction()
    {
        $brands = R::find('brand', 'LIMIT 3');
        $this->set(['brands' => $brands]);
        $this->setMeta(App::$app->getProperty('shop_name'), 'самая главная', 'круто супер главная');
    }
}