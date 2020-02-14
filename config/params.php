<?php
// Это массив настроек для приложения

return [
    'admin_email' => getenv('admin_email') ? getenv('admin_email') : 'admin@admin.ru',
    'shop_name' => 'Магазин магазинов',
    'pagination' => 3,
    'smpt_host' => 'smtp.yandex.ru',     // для отправки почты
    'smpt_port' => '465',     // для отправки почты
    'smpt_protocol' => 'SSL',     // для отправки почты
    'smpt_login' => 'test171771',  // для отправки почты
    'smpt_password' => getenv('smpt_password'),  // для отправки почты
    'email' => 'test171771@yandex.ru',  // для отправки почты
];