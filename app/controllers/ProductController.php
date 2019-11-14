<?php


namespace app\controllers;


use RedBeanPHP\R;

class ProductController extends AppController
{
    public function viewAction()
    {
        // в роут продукта сохраняем его алиас
        // прописано в config/routes.php
        $alias = $this->route['alias'];

        // делаем запрос с защитой от sql инъекции
        $product = R::findOne('product', 'alias = ? AND status = "1"', [$alias]);
        if (!$product) {
            throw new \Exception('Страница с товаром ' . $alias . ' не найдена', 404);
        }

        // еще надо получить хлебные крошки
        // еще полчать связанные товары
        $related = R::getAll("SELECT * FROM related_product JOIN product ON
            product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);

        // запись в куки запрошенного товара
        // получить просмотренные товары
        // получить галерею
        // получить все модификации товары

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related'));
    }
}