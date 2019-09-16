<?php
require_once dirname(__DIR__) . '/config/init.php'; // константы
require_once  LIBS . '/functions.php';  // свои функции (пр.: debug)

new \ishop\App();   // создали контейнер
// Положили в регистр в контейнере еще одно свойство
\ishop\App::$app->serProperty('test', 'TEST');
debug( \ishop\App::$app->getProperties() ); // выводим все свойства
/*Array
(
    [admin_email] => admin@admin.ru
    [shop_name] => Магазин магазинов
    [pagination] => 3
    [smpt_login] =>
    [smpt_password] =>
    [test] => TEST
)*/