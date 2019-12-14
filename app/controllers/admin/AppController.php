<?php


namespace app\controllers\admin;


use app\models\AppModel;
use app\models\User;
use ishop\base\Controller;
use mysql_xdevapi\Exception;

/**
 * Базовый контроллер для админки
 * Class AppController
 * @package app\controllers\admin
 */
class AppController extends Controller
{
    // переопределяем шаблон для контроллеров в админке
    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);

        // если не админ, то перекинет на страницу авторизации админов
        if (!User::isAdmin() && $route['action'] != 'login-admin') {
            redirect(ADMIN . 'user/login-admin');   // UserController::loginAdminAction
        }

        new AppModel();
    }

    // получаем id (по умолчанию) из get или post
    public function getRequestId($get = true, $id = 'id')
    {
        if ($get) {
            $data = $_GET;
        } else {
            $data = $_POST;
        }

        $id = !empty($data[$id]) ? (int)$data[$id] : null;

        if (!$id) {
            throw new \Exception('Страница не найдена', 404);
        }

        return $id;
    }
}