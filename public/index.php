<?php
require_once dirname(__DIR__) . '/config/init.php'; // константы
require_once  LIBS . '/functions.php';  // свои функции (пр.: debug)
require_once  CONF . '/routes.php';  // готовые маршруты

new \ishop\App();   // создали контейнер

//debug(\ishop\Router::getRoutes());