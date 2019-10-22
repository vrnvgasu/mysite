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
        $hits = R::find('product', "hit = '1' AND status = '1' LIMIT 8");
        $this->set(compact('brands', 'hits'));
        $this->setMeta(App::$app->getProperty('shop_name'), 'самая главная', 'круто супер главная');
    }
}