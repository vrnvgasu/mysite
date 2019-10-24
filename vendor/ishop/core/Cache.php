<?php


namespace ishop;


class Cache
{
    // только один объект
    use TSingleton;

    //Записываем значение в кэш. По умолчанию на 1 час
    public function set($key, $data, $seconds = 3600)
    {
        if ($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;

             // md4 хеширует запрещенные символы, чтобы не мешали
             // кладем в файл кэша сериализованные данные
            if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
                return true;
            }
        }

        return false;
    }

    //Получаем данные из кэша по ключу
    public function get($key)
    {
        // находим имя файлу по хешу ключа
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            // данные в файле были сериализованы
            $content = unserialize(file_get_contents($file));

            if (time() <= $content['end_time']) {
                return $content['data'];
            } else {
                // если устарел, то удаляем файл
                unlink($file);
            }
        }

        return false;
    }

    //Если есть такой кэш, то удалим его
    public function delete($key)
    {
        // находим имя файлу по хешу ключа
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}