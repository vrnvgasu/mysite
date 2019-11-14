<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Product;
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

        // получить хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

        // получать связанные товары
        $related = R::getAll("SELECT * FROM related_product JOIN product ON
            product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);

        // запись в куки запрошенного товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id); // сразу записываем в просмотренные текущий товар

        // получить просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        // если есть id в куке, то берем их из базы
        if ($r_viewed) {
            $recentlyViewed = R::find('product', 'id IN (' . R::genSlots($r_viewed) . ') LIMIT 3', $r_viewed);
        }

        // получить галерею
        $gallery = R::findAll('gallery', 'product_id = ?', [$product->id]);

        // получить все модификации товары

        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs'));
    }
}