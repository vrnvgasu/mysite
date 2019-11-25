<?php


namespace ishop\base;


use ishop\DB;

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
}
