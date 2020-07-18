<?php
namespace App;

class log
{
   public static function logData($data)
    {
        $current = file_get_contents('log.log');
        // Добавляем нового человека в файл
        $current .= print_r($data, true);
        // Пишем содержимое обратно в файл
        file_put_contents('log.log', $current);

        // $handle = fopen('log.log', "w+");
        // $req = print_r($data, true);
        // fwrite($handle, $req);
        // fclose($handle);
    }
}
