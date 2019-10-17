<?php


namespace ishop;


class DB
{
    // только один экземпляр соединения
    use TSingleton;

    protected function __construct()
    {
        // получаем настройки соединения
        $db = require_once CONF . '/config_db.php';
    }
}