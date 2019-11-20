<?php


namespace app\controllers;

/*
 * При выборе валюты надо напривить запрос /currency/change/
 */

use app\models\Cart;
use ishop\App;
use RedBeanPHP\R;

class CurrencyController extends AppController
{
    public function changeAction()
    {
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;

        if ($currency) {
            //$currencies = App::$app->getProperty('currencies');
            $curr = R::findOne('currency', 'code = ?', [$currency]);
            // Если такая валюта есть в списке валют в контейнере
            // то ставим куку с ее кодом на неделю для всего домена
            if (!empty($curr)) {
                setcookie('currency', $currency, time() + 3600 * 24 * 7, '/');
                Cart::recalc($curr);
            }
        }

        // пользовательская функция (подключил в public/index.php)
        redirect();
    }
}