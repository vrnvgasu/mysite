<?php


namespace app\controllers;

/*
 * При выборе валюты надо напривить запрос /currency/change/
 */

use ishop\App;

class CurrencyController extends AppController
{
    public function changeAction()
    {
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;

        if ($currency) {
            $currencies = App::$app->getProperty('currencies');
            // Если такая валюта есть в списке валют в контейнере
            // то ставим куку с ее кодом на неделю для всего домена
            if (isset($currencies[$currency])) {
                setcookie('currency', $currency, time() + 3600 * 24 * 7, '/');
            }
        }

        // пользовательская функция (подключил в public/index.php)
        redirect();
    }
}