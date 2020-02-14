<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
use ishop\App;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class CategoryController extends AppController
{
    public function viewAction()
    {
        $alias = $this->route['alias'];
        $category = R::findOne('category', 'alias = ?', [$alias]);

        if (!$category) {
            throw new \Exception('Страница не найдена', 404);
        }

        // хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        /** Пагинация */
        // если в uri указан номер страницы, то берем его.
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        // сколько товаров выводим на страницу
        $perpage = App::$app->getProperty('pagination');

        $sql_part = '';
        if (!empty($_GET['filter'])) {
            $filter = Filter::getFilter();
            /*
            SELECT `product`.*  FROM `product`  WHERE category_id IN (3,4,7,1)
            AND id IN (
                SELECT product_id FROM attribute_product WHERE attr_id IN ($filter)
                GROUP BY product_id
                HAVING COUNT(product_id) = кол-во выбранных категорий фильтров

            )
            */

            if ($filter) {
                $cnt = Filter::getCountGroups($filter);
                $sql_part = "AND id IN (
                    SELECT product_id " .
                    "FROM attribute_product WHERE attr_id IN ($filter) " .
                    "GROUP BY product_id " .
                    //"HAVING COUNT(product_id) = $cnt" .
                ")";
            }
        }

        // всего записей товаров для данной категории
        $total = R::count('product', "category_id IN ($ids) $sql_part");
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        // получаем все продукты текущей категории и всех вложенных
        // выборку начинаем с определенной позиции для пагинации
        $products = R::find('product', "category_id IN ($ids) 
        $sql_part LIMIT $start, $perpage");

        if ($this->isAjax() && !empty($_GET['filter'])) {
            // подгрузили вид
            $this->loadView('filter',
                compact('products', 'pagination', 'total'));
            // дальше скрипт не выполняется
        }

        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set((compact('products', 'breadcrumbs', 'pagination', 'total')));
    }
}