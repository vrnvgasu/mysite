<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ошибка</title>
</head>
<body>

<h1>Произошла ошибка</h1>
<p><b>Код ошибки:</b> <?= $errNo ?></p>
<p><b>Текст ошибки:</b> <?= $errStr ?></p>
<p><b>Файл, в котором произошла ошибка:</b> <?= $errFile ?></p>
<p><b>Строка, в которой произлошла ошибка:</b> <?= $errLine ?></p>

</body>
</html>