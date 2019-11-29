<?php


namespace app\models;


use ishop\base\Model;
use RedBeanPHP\R;

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

    public static function saveOrderProduct($order_id)
    {

    }

    public static function mailOrder($order_id)
    {

    }
}