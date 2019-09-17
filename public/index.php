<?php
require_once dirname(__DIR__) . '/config/init.php'; // константы
require_once  LIBS . '/functions.php';  // свои функции (пр.: debug)

new \ishop\App();   // создали контейнер

throw new Exception('ошибочка');