<?php


namespace app\controllers;


use RedBeanPHP\R;

class SearchController extends AppController
{
    public function typeaheadAction()
    {
        // если асинхронный запрос, то возвращаем продукты из корзины
        if ($this->isAjax()) {
           $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;

           if ($query) {
               $products = R::getAll('SELECT id, title FROM product
                    WHERE title LIKE ? LIMIT 10', ["%{$query}%"]);
               echo json_encode($products);
           }
        }
        die();
    }

    public function indexAction()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;

        if ($query) {
            $products = R::find('product',
                'title LIKE ? LIMIT 10', ["%{$query}%"]);
        } else {
            $products = null;
        }

        // передаем переменные в шаблон
        // h - своя функция проверки символов (подключаем в index.php)
        $this->setMeta('Поиск по: ' . h($query));
        $this->set(compact('products', 'query'));
    }
}