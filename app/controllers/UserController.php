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