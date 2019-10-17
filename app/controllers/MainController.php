<?php


namespace app\controllers;


class MainController extends AppController
{
    public function indexAction()
    {
        //debug($this->route);
        $this->setMeta('Главная', 'самая главная', 'круто супер главная');
    }
}