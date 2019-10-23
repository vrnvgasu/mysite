<?php


namespace app\widgets\currency;

use ishop\App;
use RedBeanPHP\R;

class Currency
{
    // шаблон выбора выпадающего списка валют
    protected $tpl;
    protected $currencies; // список доступных валют
    protected $currency; // текущая валюта

    public function __construct()
    {
        // путь к шаблогу списка валют
        $this->tpl = __DIR__ . '/currency_tpl/currency.php';
        $this->run();
    }

    /**
     * Получает список валют и текущую валюту.
     * На основе этого строит html
     */
    public function run()
    {
        // в контейнер закину в базовом контроллере AppController
        $this->currencies = App::$app->getProperty('currencies');
        $this->currency = App::$app->getProperty('currency');
        echo $this->getHtml(); // отображаем код
    }

    public static function getCurrencies()
    {
        /* возвращает ассоциативный массив. Ключ - первый атрибут
        [USD] => Array([title] => доллары
                       [symbol_left] => $
                       [symbol_right] =>
                       [value] => 1.00
                       [base] => 1)
        [RUB] => Array(...*/

        return R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base
            FROM currency ORDER BY base DESC");
    }

    /**
     * Берем текущую валюту из куки либо базовою валюту
     */
    public static function getCurrency($currencies)
    {
        if (isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)) {
            $key = $_COOKIE['currency'];
        } else {
            // key($arr) — передает текущий элемент массива. Будет стваить USD
            // т.к. делали сортировку $currencies по базовой валюте
            $key = key($currencies);
        }

        $currency = $currencies[$key];
        $currency['code'] = $key;

        return $currency;
    }

    // подключает шаблон $this->tpl
    protected function getHtml()
    {
        ob_start(); // шаблон сохраняем в буфер
        require_once $this->tpl;
        return ob_get_clean(); // возвращаем код шаблона из буфера
    }
}
