<?php


namespace ishop;


class ErrorHandler
{
    public function __construct()
    {
        // среда для обработки ошибок
        if (DEBUG) {
            // Report all PHP errors
           error_reporting(-1); 
        } else {
            // Turn off all error reporting
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }

    // Обработчик ошибок
    public function exceptionHandler($e)
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(),$e->getFile(), $e->getLine(), $e->getCode());
    }

    // Логируем ошибки
    protected function logErrors($message = '', $file = '', $line = '')
    {
        $message = "[" . date("Y-m-d H:i:s") . "] Тест ошибки: {$message} | Файл: {$file} | Строка: {$line}";
        $message .= "\n===============\n";
        // логируем в выбранный файл
        error_log($message, 3, ROOT . '/tmp/errors.log');
    }

    // Вывод ошибок
    protected function displayError($errNo, $errStr, $errFile, $errLine, $responce = 404)
    {
        http_response_code($responce);

        // если среда разработки, то будем все ошибки выводить
        if ($responce == 404 && !DEBUG) {
            require_once WWW . '/errors/404.php';
            die();
        }

        if (DEBUG) {
            require_once WWW . '/errors/dev.php';
        } else {
            require_once WWW . '/errors/prod.php';
        }
        die();
    }
}