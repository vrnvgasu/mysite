<?php


namespace app\controllers\admin;


use ishop\base\Controller;

/**
 * Базовый контроллер для админки
 * Class AppController
 * @package app\controllers\admin
 */
class AppController extends Controller
{
    // переопределяем шаблон для контроллеров в админке
    public $layout = 'admin';
}