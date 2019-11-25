<?php


namespace app\controllers;


use app\models\User;

class UserController extends AppController
{
    // регистрация
    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            // делаем автозаполнение модели данными
            $user->load($data);

            if (!$user->validate($data)) {
                // запишем ошибки в сессию и вернем страницу
                // при редеректе данные из формы еще удалятся
                $user->getErrors();
                redirect();
            } else {
                $_SESSION['success'] = 'OK';
                redirect();
            }
        }

        $this->setMeta('Регистрация');


    }

    // авторизация
    public function loginAction()
    {

    }

    // выход
    public function logoutAction()
    {

    }
}