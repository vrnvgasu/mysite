<?php


namespace ishop;


use mysql_xdevapi\Exception;

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

    // вызывает существующий контроллер и его метод (action)
    // также отрисовываем страницу через метод контроллера getView()
    // или возвращает 404
    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            // есть маршрут
            $controller = 'app\controllers\\' . self::$route['prefix'] .
                self::$route['controller'] . 'Controller';
            /**
             * http://mysite.test/page/view
             * $controller == app\contrlollers\PageController
             */

            // находим класс нужного контроллера и создаем его экземпляр
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::$route['action'];
                $action = self::lowerCamelCase($action) . 'Action';

                // вызываем нужный метод
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                    // Отрисовали страницу
                    $controllerObject->getView();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден",
                    404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден",
                    404);
            }
        } else {
            // не нашли маршрут. Ошибка, которую перехватит ErrorHandler
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /** Проверяет, есть ли такой маршрут
     * @param $url
     * @return bool
     */
    public static function matchRoute($url) : bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url, $matches)) {
                /**http://mysite.test/page/view
                 * $matches - Array
                [0] => page/view
                [controller] => page
                [1] => page
                [action] => view
                [2] => view
                 */
                // возьмем только строковые ключи из $matches
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action'])) $route['action'] = 'index';

                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    // добавим обратный слеш в конце строки
                    $route['prefix'] .= '\\';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                /**$route Array
                [action] => view
                [prefix] =>
                [controller] => Page
                 */

                return true;
            }
        }

        return false;
    }

    // CamelCase
    protected static function upperCamelCase($name)
    {
        $name = ucwords(str_replace('-', ' ', $name));
        $name = str_replace(' ', '', $name);

        return $name;
    }

    // camelCase
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
}