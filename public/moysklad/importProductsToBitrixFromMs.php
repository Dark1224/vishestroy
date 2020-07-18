<?php
die('you dont have enough permissions');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'curl.php';
include_once 'log.php';

// $res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/counterparty', false);
// $res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/organization', false);
function getAllProducts($url = 'https://online.moysklad.ru/api/remap/1.1/entity/product?limit=100', $arr = []){
	$res = callAPI('GET', $url, false);

	foreach ($res['rows'] as $key => $value) {
		$arr[] = $value;
	}
	if( isset($res['meta']['nextHref']) && $res['meta']['nextHref'] != ''){
		return getAllProducts($res['meta']['nextHref'], $arr);
		// return $arr;
	}else{
		return $arr;
	}
}

$products = getAllProducts();
foreach ($products as $key => $value) {
    callMethod('crm.product.add',[
        'fields' => [
            'NAME' => $value['name'],
            'PROPERTY_103' => $value['id'],
            'PROPERTY_105' => $value['accountId']
        ]
    ]);
}
// $res = callAPI('GET', 'https://online.moysklad.ru/api/remap/1.1/entity/product', false);
echo "<pre>";
print_r($products);