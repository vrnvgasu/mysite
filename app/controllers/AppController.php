<?php


namespace app\controllers;


use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\App;
use ishop\base\Controller;
use ishop\Cache;
use RedBeanPHP\R;

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

        //Засовываем список валют в регистр в контейнере
        App::$app->serProperty('currencies', Currency::getCurrencies());
        //Засовываем текущую валюту в регистр в контейнере
        $currency = Currency::getCurrency( App::$app->getProperty('currencies'));
        App::$app->serProperty('currency', $currency);

        // Засовываем список категорий в контейнер
        App::$app->serProperty('cats', static::cacheCategory());
    }

    // Кэширование категорий
    public static function cacheCategory()
    {
        $cache = Cache::instance();
        $cats = $cache->get('cats');

        if (!$cats) {
            $cats = R::getAssoc("SELECT * FROM category");
            $cache->set('cats', $cats);
        }

        return $cats;
    }
}