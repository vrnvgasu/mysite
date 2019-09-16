<?php
define("DEBUG", 1);     // режим отладки (прод или локалка)
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/ishop/core');
define("LIBS", ROOT . '/vendor/ishop/core/libs');
define("CACHE", ROOT . '/tmp/cache');   // папка кэша
define("CONF", ROOT . '/config');
define("LAYOUT", ROOT . 'default'); // название шаблона по умолчанию

// http://mysite.test/index.php
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
// http://mysite.test/
$app_path = preg_replace("#[^/]+$#", "", $app_path);

// костыль, чтобы получить http://mysite.test
$app_path .= 't';
$app_path = str_replace('/t', "", $app_path);

define("PATH", $app_path);
define("ADMIN", PATH . '/admin');

// подключили здесь автозагрузчик
require_once ROOT . '/vendor/autoload.php';