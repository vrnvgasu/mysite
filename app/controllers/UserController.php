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

            //если невалидные данные или пользователь уже есть,
            // то вернем ошибку
            if (!$user->validate($data) ||
            !$user->checkUnique()) {
                // запишем ошибки в сессию и вернем страницу
                // при редеректе данные из формы еще удалятся
                $user->getErrors();
            } else {
                // захешируем пароль перед сохранением
                $user->attributes['password'] = password_hash($user->attributes['password'],
                PASSWORD_DEFAULT);
                if ($user->save('user')) {
                    $_SESSION['success'] = 'Пользователь зарегистрирован';
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

    }

    // выход
    public function logoutAction()
    {

    }
}