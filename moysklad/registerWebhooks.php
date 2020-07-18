<?php
// $res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/counterparty', false);
// $res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/organization', false);
include_once 'curl.php';
include_once 'log.php';

//$data = json_encode([
//  "url"=> "https://webhook.site/8ef63d84-4ad0-4daa-b7c8-5bee7e197502",
//  "action"=> "UPDATE",
//  "entityType"=> "customerorder"
//], JSON_UNESCAPED_UNICODE);

$data = json_encode([
    "url"=> "https://neoteric-software.com/moysklad/msToBitrix/index.php",
], JSON_UNESCAPED_UNICODE);
$res = callAPI('PUT', 'https://online.moysklad.ru/api/remap/1.1/entity/webhook/35b13f0a-4c9f-11ea-0a80-04eb000289f7', $data);
echo "<pre>";
print_r($res);







//$data = json_encode([
//    "url"=> "https://neoteric-software.com/moysklad/msToBitrix/index.php",
//    "action"=> "UPDATE",
//    "entityType"=> "customerorder"
//], JSON_UNESCAPED_UNICODE);
//$res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/webhook', false);
//echo "<pre>";
//print_r($res);