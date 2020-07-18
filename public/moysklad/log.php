<?php
	// function logData($data) {
	// 	date_default_timezone_set('Asia/Yerevan');
	// 	file_put_contents('log.log', print_r(array(date('Y-m-d H:i:s') => $data), true)."\n", FILE_APPEND);
	// }

function logData($data) {
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
?>