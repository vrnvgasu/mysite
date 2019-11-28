<?php


namespace ishop\base;


use ishop\DB;
use RedBeanPHP\R;
use Valitron\Validator;

abstract class Model
{
    // в нем хранятся данные с названия идентичными в БД
    public $attributes = [];
    public $errors = []; // собираем ошибки
    public $rules = []; // для валидации данных

    public function __construct()
    {
        // создаем подключение 1 раз через singleton
        DB::instance();
    }

    // заполняем атрибуты из переданных значений
    // типа автозаполнения
    // в автозагузку попадут только поля указанные в $attributes
    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    // валидация
    public function validate($data)
    {
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);

        if ($v->validate()) {
            return true;
        }

        $this->errors = $v->errors();

        return false;
    }

    /*
     * Получаем ошибки валидации
     *  [errors] => Array
        (
            [email] => Array
                (
                    [0] => Email is not a valid email address
                )

            [password] => Array
                (
                    [0] => Password must be at least 6 characters long
                )

        )
     */
    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    // надо записать значения из атрибутов модели в таблицу
    public function save($table)
    {
        //создаем объект ORM для данной таблицы
        // заполняем его и сохраняем
        $tbl = R::dispense($table);

        foreach ($this->attributes as $name => $value) {
            $tbl->$name = $value;
        }

        // передает true или false
        return R::store($tbl);
    }
}
