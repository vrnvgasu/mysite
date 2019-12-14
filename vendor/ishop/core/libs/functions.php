<?php
// Служебные функции

function debug($arr, $die = false) {
    echo "<pre>" . print_r($arr, true) . "</pre>";
    if ($die) die();
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

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}