<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\User;
use ishop\App;
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

    // полчить шаблон (вид) корзины
    public function showAction()
    {
        //метод описан в абстрактном контроллере. Просто возвращает нужный шаблон
        $this->loadView('cart_modal');
    }

    public function deleteAction()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] : null;

        if (isset($_SESSION['cart'][$id])) {
            $cart = new Cart();
            // удаляем этот id из сессии корзины
            $cart->deleteItem($id);
        }

        // если асинхронный запрос, то возвращаем вид корзины
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        // иначе возвращаем обратно
        redirect();
    }

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);

        // если асинхронный запрос, то возвращаем вид корзины
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        // иначе возвращаем обратно
        redirect();
    }

    public function viewAction()
    {
        $this->setMeta('Корзина');
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            // регистрация пользователя
            if (!User::checkAuth()) {
                $user = new User();
                $data = $_POST;
                // делаем автозаполнение модели данными
                $user->load($data);

                //если невалидные данные или пользователь уже есть,
                // то вернем ошибку
                if (!$user->validate($data) ||
                    !$user->checkUnique()) {
                    // запишем ошибки в сессию и вернем страницу
                    // при редеректе данные из формы еще удалятся
                    $user->getErrors();

                    // при ошибке вернем данные пользовалю,
                    // чтобы заново все не надо было заполнять
                    $_SESSION['form_data'] = $data;
                    redirect();
                } else {
                    // захешируем пароль перед сохранением
                    $user->attributes['password'] = password_hash($user->attributes['password'],
                        PASSWORD_DEFAULT);
                    if (!$user_id = $user->save('user')) {
                        $_SESSION['error'] = 'Ошибка!';
                        redirect();
                    } else {
                        $user->login();
                    }
                }
            }

            /**
             * сохранение заказа
            **/
            $data['user_id'] = $user_id ?? $_SESSION['user']['id'];
            $data['note'] = !empty($_POST['note']) ? $_POST['note'] : '';
            $user_email = $_SESSION['user']['email'] ?? $_POST['email'];

            // сохранили заказ
            $order_id = Order::saveOrder($data);

            /**
             * Данные для оплаты
             */
            if (!empty($_POST['pay'])) {
                static::setPaymentData($order_id);
            }

            // отправили письмо о заказе
            Order::mailOrder($order_id, $user_email);

            if (!empty($_POST['pay'])) {
                redirect(PATH . '/payment/form.php');
            }
        }

        redirect();
    }

    protected static function setPaymentData($order_id)
    {
        if (isset($_SESSION['payment'])) {
            unset($_SESSION['payment']);
        }

        $_SESSION['payment']['id'] = $order_id;
        $_SESSION['payment']['curr'] = $_SESSION['cart.currency']['code'];
        $_SESSION['payment']['sum'] = $_SESSION['cart.sum'];
    }

    public function paymentAction(){
        if(empty($_POST)){
            die;
        }

        /**
         * данные от интеркассы
         */
        $dataSet = $_POST;

        /**
         * код из документации интеркассы
         * https://www.interkassa.com/index.php/documentation-sci/
         */
        unset($dataSet['ik_sign']);
        ksort($dataSet, SORT_STRING);
        array_push($dataSet, App::$app->getProperty('ik_key'));
        $signString = implode(':', $dataSet);
        $sign = base64_encode(md5($signString, true));

        // ik_pm_no - номер заказа (передаем id из order и его получаем обратно)
        $order = R::load('order', (int)$dataSet['ik_pm_no']);
        if(!$order) die;

        /**
         * Проверяем данные ответа из интеркассы,
         * чтобы пользователь не подменил их
         */
        if($dataSet['ik_co_id'] != App::$app->getProperty('ik_id') ||
            $dataSet['ik_inv_st'] != 'success' || $dataSet['ik_am'] != $order->sum ||
            $sign != $_POST['ik_sign'] || $dataSet['ik_cur'] != $order->currency ){
            die;
        }

        $order->status = 2;
        R::store($order);
        die;
    }
}