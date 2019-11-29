<?php


namespace app\controllers;


use app\models\User;

class UserController extends AppController
{
    // регистрация
    public function signupAction()
    {
        // если авторизован, то сразу на главную страницу кидаем
        if (isset($_SESSION['user'])) {
            redirect(PATH);
        }

        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            // делаем автозаполнение модели данными
            $user->load($data);

            //если невалидные данные или пользователь уже есть,
            // то вернем ошибку
            if (!$user->validate($data) ||
            !$user->checkUnique()) {
                // запишем ошибки в сессию и вернем страницу
                // при редеректе данные из формы еще удалятся
                $user->getErrors();

                // при ошибке вернем данные пользовалю,
                // чтобы заново все не надо было заполнять
                $_SESSION['form_data'] = $data;

            } else {
                // захешируем пароль перед сохранением
                $user->attributes['password'] = password_hash($user->attributes['password'],
                PASSWORD_DEFAULT);
                if ($user->save('user')) {
                    $_SESSION['success'] = 'Пользователь зарегистрирован';

                    // сразу авторизуем, пока в $_POST остались данные
                    $user->login();
                    redirect();
                } else {
                    $_SESSION['error'] = 'Ошибка!';
                }
            }

            redirect();
        }

        $this->setMeta('Регистрация');


    }

    // авторизация
    public function loginAction()
    {
        // если авторизован, то сразу на главную страницу кидаем
        if (isset($_SESSION['user'])) {
            redirect(PATH);
        }

        if (!empty($_POST)) {
            $user = new User();

            if ($user->login()) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }

            redirect();
        }

        $this->setMeta('Вход');
    }

    // выход
    public function logoutAction()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        redirect();
    }
}