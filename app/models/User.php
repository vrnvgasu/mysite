<?php


namespace app\models;


use RedBeanPHP\R;

class User extends AppModel
{
    // атрибуты для автозаполнения
    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
    ];

    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['name'],
            ['email'],
            ['address'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ],
    ];

    // проверяем, что такого пользователя нет
    public function checkUnique()
    {
        $user = R::findOne('user',
            'login = ? OR email = ?',
            [$this->attributes['login'], $this->attributes['email']]);

        if ($user) {
            if ($user->login === $this->attributes['login']) {
                $this->errors['unique'][] = 'Этот логин уже занят';
            }
            if ($user->email === $this->attributes['email']) {
                $this->errors['unique'][] = 'Этот email уже занят';
            }

            return false;
        }

        return true;
    }

    public function login($isAdmin = false)
    {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if ($login && $password) {
            // ищем в базе по логину админа или обычного пользователя
            if ($isAdmin) {
                $user = R::findOne('user',
                    "login = ? AND role = 'admin", [$login]);
            } else {
                $user = R::findOne('user', "login = ?", [$login]);
            }

            if ($user) {
                // если пользователь есть в базе, то проверяем хеш
                // пароля из формы с хешем из базы
                if (password_verify($password, $user->password)) {
                    // добавляем все данные о пользователи (кроме пароля)
                    // в сессию
                    foreach ($user as $k => $v) {
                        if ($k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }

                    return true;
                }
            }
        }

        return false;
    }
}