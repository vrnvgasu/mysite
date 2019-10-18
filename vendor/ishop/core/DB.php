<?php


namespace ishop;

// Библиоетка ORM
use \RedBeanPHP\R as R;

class DB
{
    // только один экземпляр соединения
    use TSingleton;

    protected function __construct()
    {
        // получаем настройки соединения
        $db = require_once CONF . '/config_db.php';

        // подключаем ORM
        R::setup($db['dsn'], $db['user'], $db['pass']);
        if (!R::testConnection()) {
            throw new \Exception("Нет соединения с БД", 500);
        }
        R::freeze(true); // режим не позволяет изменять структуру таблиц через ORM
        if (DEBUG) {
            R::debug(true, 1); // выводит все запросы. Обрабатываем это в шаблоне default
        }
        
    }
}