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
    'img_width' => 125,
    'img_height' => 200,
    'gallery_width' => 700,
    'gallery_height' => 1000,
    /**
     * Редактирование кассы - безопасность - тестовый ключ
     */
    'ik_key' => getenv('ik_key'),
    /**
     * Идентификатор кассы
     */
    'ik_id' => '5e727d081ae1bd24008b4572',
];