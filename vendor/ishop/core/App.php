<?php


namespace ishop;


class App
{
    public static $app; // это будет контейнер

    public function __construct()
    {
        $query = trim($_SERVER['REQUEST_URI'], '/');
        session_start();

        // Это контейнер, в котором записан объект реестра,
        // который собирает другие объекты и массив параметров
        self::$app = Registry::instance();
        $this->getParams(); // заполняем контейнер параметрами
    }

    protected function getParams()
    {
        $params = require_once CONF . '/params.php';

        if (!empty($params)) {
            foreach ($params as $k => $v) {
                self::$app->serProperty($k, $v);
            }
        }
    }
}