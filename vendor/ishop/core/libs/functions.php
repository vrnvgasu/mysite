<?php
// Служебные функции

function debug($arr) {
    echo "<pre>" . print_r($arr, true) . "</pre>";
}

function redirect($http = false) {
    if ($http) {
        $redirect = $http;
    } else {
        // обновляем страницу или кидаем на главную
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }

    // делаем редирект
    header("Location: $redirect");
    exit;
}