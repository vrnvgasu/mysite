<?php


namespace app\models;


use ishop\App;
use ishop\base\Model;
use RedBeanPHP\R;
use Swift_Mailer;
use Swift_Message;

class Order extends Model
{
    public $attributes = [
        'user_id' => '',
        'currency' => '',
        'note' => '',
    ];

    // сохраняем заказ
    public static function saveOrder($data)
    {
        $data['currency'] = $_SESSION['cart.currency']['code'];

        $order = new static;
        $order->load($data);
        $order_id = $order->save('order');

        self::saveOrderProduct($order_id);

        return $order_id;
    }

    /*
     * Пример корзины в сессии
Array(
    [cart.currency] => Array
            [title] => доллары
            [symbol_left] => $
            [symbol_right] =>
            [value] => 1.00
            [base] => 1
            [code] => USD
    [cart] => Array
            [2] => Array
                    [qty] => 1
                    [title] => xfcs 2
                    [alias] => chasi-2
                    [price] => 70
                    [img] => no_image.jpg
            [3] => Array(
                    [qty] => 1
                    [title] => вау
                    [alias] => wau
                    [price] => 80
                    [img] => no_image.jpg
            [2-3] => Array                                 // товар модификатор
                    [qty] => 5
                    [title] => xfcs 2 (red)
                    [alias] => chasi-2
                    [price] => 80
                    [img] => no_image.jpg

    [cart.qty] => 7
    [cart.sum] => 550
    [user] => Array(
            [id] => 11
            [login] => user3
            [email] => test@tedfst.ru
            [name] => asdf
            [address] => asdf
            [role] => user
     */
    // задача сохранить товары из корзины  в таблицу order_product
    // (связанные через внешний ключ $order_id с таблицей заказов
    public static function saveOrderProduct($order_id)
    {
        $sql_part = '';

        foreach ($_SESSION['cart'] as $product_id => $product) {
            // $product_id типа 2-3 приведем к 2
            $product_id = (int)$product_id;

            //{$product['title']} в кавычках, т.к. это данные в виде строки
            $sql_part .= "($order_id, $product_id, {$product['qty']},
            '{$product['title']}', {$product['price']}),";
        }

        // (6, 2, 1, 'xfcs 2', 70),(6, 3, 1, 'вау', 80),(6, 2, 5, 'xfcs 2 (red)', 80)
        $sql_part = rtrim($sql_part, ',');

        R::exec("INSERT INTO order_product 
(order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    public static function mailOrder($order_id, $user_email)
    {
        /**
         * https://swiftmailer.symfony.com/docs/introduction.html
         **/

        // Create the Transport
        $transport = (new \Swift_SmtpTransport(App::$app->getProperty('smpt_host'),
            App::$app->getProperty('smpt_port'),
            App::$app->getProperty('smpt_protocol')))
            ->setUsername(App::$app->getProperty('smpt_login'))
            ->setPassword(App::$app->getProperty('smpt_password'));

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // сохраним шаблон письма в буфер
        ob_start();
        require APP . '/views/mail/mail_order.php';
        $body = ob_get_clean();

        // Create a message
        $message_client = (new Swift_Message("Заказ №{$order_id}"))
            ->setFrom([App::$app->getProperty('email') => App::$app->getProperty('shop_name')])
            ->setTo($user_email)
            ->setBody($body)
        ;

        $message_admin = (new Swift_Message("Заказ №{$order_id}"))
            ->setFrom([App::$app->getProperty('email') => App::$app->getProperty('shop_name')])
            ->setTo(App::$app->getProperty('admin_email'))
            ->setBody($body)
        ;

        // Send the message
        $result = $mailer->send($message_client);
        $result = $mailer->send($message_admin);

        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);

        $_SESSION['success'] = 'Спасибо за заказ. С Вами свяжется менеджер';
    }
}
