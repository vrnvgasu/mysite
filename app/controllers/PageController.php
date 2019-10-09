<?php


namespace app\controllers;


class PageController extends AppController
{
    public function viewAction()
    {
        echo __METHOD__;
    }

    public function indexAction()
    {
        echo __METHOD__, PHP_EOL;
        echo 'куку';
    }
}