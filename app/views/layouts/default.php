<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0,
            maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= $meta ?? ''; ?>
</head>
<body>

<h1>Шаблон DEFAULT</h1>

<?= $content ?? ''; ?>


<?php
    // выводим все запросы в режиме отладки (см. ishop/core/DB.php)
    $logs = \RedBeanPHP\R::getDatabaseAdapter()
        ->getDatabase()
        ->getLogger();

    debug( $logs->grep( 'SELECT' ) );
    // Пр. Array ( [0] => SELECT `test`.* FROM `test` -- keep-cache )
?>
</body>
</html>
