<?php


namespace app\controllers\admin;


use app\models\admin\Product;
use app\models\AppModel;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class ProductController extends AppController
{
    public function indexAction()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $count = R::count('product');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();
        $products = R::getAll("SELECT product.*, 
        category.title AS cat 
        FROM product
        JOIN category ON category.id = product.category_id 
        ORDER BY product.title 
        LIMIT $start, $perpage");

        $this->setMeta('Список товаров');
        $this->set(compact('products', 'pagination', 'count'));
    }

    public function addAction()
    {
        if (!empty($_POST)) {
            $product = new Product();
            $data = $_POST;
            /**
             * в data получаем
             * Array
            (
            [title] => Salesforce
            [category_id] => 3
            [keywords] => 11
            [description] => Fork from https://javascript.info/type-conversions#tostring
            [price] => 3
            [old_price] => 11
            [content] =>123123123
            [status] => on
            [hit] => on
            [attrs] => Array
            (
            [1] => 1
            [2] => 3
            [3] => 5
            [4] => 7
            [5] => 9
            )
            )*/
            $product->load($data);
            $product->attributes['status'] = $product->attributes['status'] ? 1 : 0;
            $product->attributes['hit'] = $product->attributes['hit'] ? 1 : 0;

            if (!$product->validate($data)) {
                $product->getErrors();
                $_SESSION['form_data'] = $data;
                redirect();
            }

            if (!$product->attributes['old_price']) {
                unset($product->attributes['old_price']);
            }

            if ($id = $product->save('product')) {
                $alias = AppModel::createAlias('product', 'alias', $data['title'], $id);
                $p = R::load('product', $id);
                $p->alias = $alias;
                R::store($p);

                $product->editFilter($id, $data); // добавляем атрибуты

                $_SESSION['success'] = 'Товар добавлен';
            }
            redirect();
        }

        $this->setMeta('Новый товар');
    }

    public function relatedProductAction()
    {
        // q - приходит запрос из select2 (для связанных товаров)
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        $data['items'] = [];
        $products = R::getAssoc('SELECT id, title FROM product ' .
            'WHERE title LIKE ? LIMIT 10', ["%{$q}%"]);
        if ($products) {
            $i = 0;
            foreach ($products as $id => $title) {
                $data['items'][$i]['id'] = $id;
                $data['items'][$i]['text'] = $title;
                $i++;
            }
        }

        echo json_encode($data);
        /**
         * [{id: 1, text: "часы 1"}, {id: 2, text: "xfcs 2 "}, {id: 9, text: "tur"}, {id: 10, text: "test"},…]
         */
        die;
    }
}
