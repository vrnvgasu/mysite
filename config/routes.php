<?php

use ishop\Router;

//default routes - добавляем дефолтные маршруты

// Для админки
Router::add('^admin$', [
    'controller' => 'Main',
    'action' => 'index',
    'prefix' => 'admin',        // префикс для названия каталога
]);
// контроллер и экшн возьмем динамически
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)$',
    ['prefix' => 'admin',]);

//Для пользовательской части
// '^$' - пустая строка
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)$');