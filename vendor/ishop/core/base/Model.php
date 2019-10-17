<?php


namespace ishop\base;


abstract class Model
{
    // в нем хранятся данные с названия идентичными в БД
    public $attributes = [];
    public $errors = []; // собираем ошибки
    public $rules = []; // для валидации данных

    public function __construct()
    {
        
    }
}