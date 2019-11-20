<?php


namespace app\models;


use ishop\App;

class Cart extends AppModel
{
    /*
     * Хранить корзину будем в сессии
    [
        [1 (id товара)] => [
                    [qty] => QTU,
                    [name] => NAME,
                    [price] => PRICE,
                    [img] => IMG,
                ],
        [10] => [
                    [qty] => QTU,
                    [name] => NAME,
                    [price] => PRICE,
                    [img] => IMG,
                ],
        ],
        [qty] => QTU,
        [sum] => SUM
     */
    public function addToCart ($product, $qty = 1, $mod = null)
    {
        // Если в сессии для корзины нет такой валюты, то добавим
        // текущую валюты из контейнера
        if (!isset($_SESSION['cart.currency'])) {
            $_SESSION['cart.currency'] = App::$app->getProperty('currency');
        }

        // id для массива товаров в корзине в сессии будет вида:
        // idПродукта - если нет модификатора
        // idПродукта-idМодификатора - если прередали модификатор
        if($mod) {
            $ID = "{$product->id}-{$mod->id}";
            $title = "{$product->title} ({$mod->title})";
            $price = $mod->price;
        } else {
            $ID = $product->id;
            $title = $product->title;
            $price = $product->price;
        }

        // если такой товар есть в сессии, то добавляем количество
        // если нет товара, то добавляем его в сессию
        if (isset($_SESSION['cart'][$ID])) {
            $_SESSION['cart'][$ID]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$ID] = [
                'qty' => $qty,
                'title' => $title,
                'alias' => $product->alias,
                'price' => $price * $_SESSION['cart.currency']['value'],
                'img' => $product->img,
            ];
        }

        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ?
            $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ?
            $_SESSION['cart.sum'] + $qty * $price * $_SESSION['cart.currency']['value'] :
            $qty * $price * $_SESSION['cart.currency']['value'];
    }

    public function deleteItem($id)
    {
        // вычитаем удаляемый товар из общей суммы и кол-ва
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];

        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;

        unset($_SESSION['cart'][$id]);
    }

    /**Пересчет валюты в корзине*/
    /*
(
    [cart.currency] => Array
        (
            [title] => доллары
            [symbol_left] => $
            [symbol_right] =>
            [value] => 1.00
            [base] => 1
            [code] => USD
            [id] => 5
        )

    [cart] => Array
        (
            [2] => Array
                (
                    [qty] => 1
                    [title] => xfcs 2
                    [alias] => chasi-2
                    [price] => 70
                    [img] => no_image.jpg
                )

        )

    [cart.qty] => 1
    [cart.sum] => 70
)
     */
    public static function recalc($curr)
    {
        if (isset($_SESSION['cart.currency'])) {
            $_SESSION['cart.sum'] = $_SESSION['cart.sum'] /
                $_SESSION['cart.currency']['value'] * $curr->value;

            foreach ($_SESSION['cart'] as $k => $v) {
                $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] /
                    $_SESSION['cart.currency']['value'] * $curr->value;
            }

            foreach ($curr as $k => $v) {
                $_SESSION['cart.currency'][$k] = $v;
            }
        }
    }
}
