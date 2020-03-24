<?php

namespace app\controllers;

use ishop\App;
use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction()
    {
        $brands = R::find('brand', 'LIMIT 3');
        $hits = R::find('product', "hit = '1' AND status = '1' LIMIT 8");

        /**
         * ссылка на страницу для поисковика
         */
        $canonical = PATH;

        $this->setMeta(App::$app->getProperty('shop_name'), 'самая главная', 'круто супер главная');
        $this->set(compact('brands', 'hits', 'canonical'));
    }
}