<?php


namespace app\controllers;


use app\models\AppModel;
use ishop\base\Controller;

/**
 * Это будет базовый класс
 * Class AppController
 * @package app\controllers
 */
class AppController extends Controller
{
    public function __construct($route)
    {
        // сохраняем родительский __construct из асбтр. кл. Controller
        parent::__construct($route);
        new AppModel();
    }
}