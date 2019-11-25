<?php


namespace app\models;


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
}