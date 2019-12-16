<?php


namespace app\controllers\admin;


use app\models\User;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class UserController extends AppController
{
    public function indexAction()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 4;
        $count = R::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();
        $users = R::findAll('user', "LIMIT $start, $perpage");

        $this->setMeta('Список пользователей');
        $this->set(compact('users', 'pagination', 'count'));
    }

    public function editAction()
    {
        if (!empty($_POST)) {
            $user_id = $this->getRequestId(false);
            $user = new \app\models\admin\User();

            $data = $_POST;
            $user->load($data);

            // если не передаем пароль при редактировании, то удалим его
            if (!$user->attributes['password']) {
                unset($user->attributes['password']);
            } else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            }

            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
                redirect();
            }

            if ($user->update('user', $user_id)) {
                $_SESSION['success'] = 'Изменения сохранены';
            }

            redirect();
        }

        $user_id = $this->getRequestId();
        $user = R::load('user', $user_id);

        // пагинация, т.к. заказов много
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 2;
        $count = R::count('order', 'WHERE user_id = ?', [$user_id]);
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();

        $orders = R::getAll("SELECT `order`.`id`, `order`.`user_id`, `order`.`status`,
         `order`.`date`, `order`.`update_at`, `order`.`currency`, ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
         FROM `order` 
         JOIN `order_product` ON `order`.`id`=`order_product`.`order_id` 
         WHERE `order`.`user_id` = {$user_id}
         GROUP BY `order`.`id` 
         ORDER BY `order`.`status`, `order`.`id` 
         LIMIT $start, $perpage");

        $this->setMeta('Редактирование пользователя');
        $this->set(compact('user', 'pagination', 'count', 'orders'));
    }

    public function loginAdminAction()
    {
        if (!empty($_POST)) {
            $user = new User();

            if ($user->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }

            if (User::isAdmin()) {
                redirect(ADMIN);
            } else {
                redirect();
            }
        }
        $this->layout = 'login';    // не будем выводить шаблон админа (только авторизациб)
    }
}