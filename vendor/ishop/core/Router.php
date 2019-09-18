<?php


namespace ishop;


class Router
{
    protected static $routes = [];  //все маршруты
    protected static $route = [];   //текущий маршрут

    /**записывает правила в таблицу маршрутов
     * @param $regexp       // регулярное выражение
     * @param array $route  // конкретный экшн, который соотвествует рег выражению
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    // для тестирования
    public static function getRoutes()
    {
        return self::$routes;
    }

    // для тестирования
    public static function getRoute()
    {
        return self::$route;
    }

    // вызывает существующий контроллер
    // или возвращает 404
    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            echo 'OK';      // есть маршрут
        } else {
            echo 'NO';      // не нашли маршрут
        }
    }

    /** Проверяет, есть ли такой маршрут
     * @param $url
     * @return bool
     */
    public static function matchRoute($url) : bool
    {
        return false;
    }
}