<?php


namespace app\controllers;


use app\models\Cart;
use RedBeanPHP\R;

class CartController extends AppController
{
    public function addAction()
    {
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
        $mod = null;

        if ($id) {
            $product = R::findOne('product', 'id = ?', [$id]);

            if (!$product) {
                return false;
            }

            // если есть продукт, то проверим, пришел ли его модификатор
            if ($mod_id) {
                $mod = R::findOne('modification', 'id = ? AND product_id = ?',
                    [$mod_id, $id]);
            }
        }

        $cart = new Cart();
        $cart->addToCart($product, $qty, $mod);

        // если асинхронный запрос, то возвращаем вид корзины
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        // иначе возвращаем обратно
        redirect();
    }
}