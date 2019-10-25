<?php

use ishop\Router;

// роут для карточки продукта http://mysite.test/product/chasi-2
Router::add('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);
/**
    [controller] => Product
    [action] => view
    [alias] => chasi-1
    [prefix] =>
 */


//default routes - добавляем дефолтные маршруты

// Для админки
Router::add('^admin$', [
    'controller' => 'Main',
    'action' => 'index',
    'prefix' => 'admin',        // префикс для названия каталога
]);
// контроллер и экшн возьмем динамически
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$',
    ['prefix' => 'admin',]);

//Для пользовательской части
// '^$' - пустая строка
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');