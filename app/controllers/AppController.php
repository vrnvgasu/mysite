<?php


namespace app\controllers;


use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
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

        // вручную поставим куку евро на весь сайт. Должны получить соответствующую $currency
        setcookie('currency', 'EUR', time() + 3600*24*7, '/');
        //Засовываем список валют в регистр в контейнере
        App::$app->serProperty('currencies', Currency::getCurrencies());
        //Засовываем текущую валюту в регистр в контейнере
        $currency = Currency::getCurrency( App::$app->getProperty('currencies'));
        App::$app->serProperty('currency', $currency);
        debug(App::$app->getProperties());
    }
}