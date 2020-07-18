<?php
die('hie');
include_once 'curl.php';
include_once 'log.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
set_time_limit (0);
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

if (isset($_REQUEST['event']) && $_REQUEST['event'] == 'ONCRMCOMPANYADD') {

    $company_id = $_REQUEST['data']['FIELDS']['ID'];
    $company = callMethod('crm.company.list',[
        'filter' => [ 'ID' => $company_id, ],
        'select' => ['*', 'PHONE', "EMAIL"]
    ])[0];
    logData($company);
     $company_requisite = callMethod('crm.requisite.list',[
        'filter' => ['ENTITY_ID' => $company_id]
    ])[0];
     $company_address = callMethod('crm.address.list',[
        'filter' => ['ENTITY_ID' => $company_id]
    ]);

     $data = json_encode([
      "name"=> $company['TITLE'],
      "description"=> $company['COMMENTS'],
      "email"=> $company['EMAIL'][0]['VALUE'],
      "phone"=> $company['PHONE'][0]['VALUE'],
      "actualAddress"=> $company_address[4]['CITY'] . ' ' . $company_address[4]['COUNTRY'] . ' ' . $company_address[4]['PROVINCE'] . ' ' . $company_address[4]['REGION'] . ' ' . $company_address[4]['ADDRESS_1'] . ' ' . $company_address[4]['ADDRESS_2'],
      "legalTitle"=> $company_requisite['RQ_COMPANY_FULL_NAME'],
      "legalAddress"=> $company_address[2]['CITY'] . ' ' . $company_address[2]['COUNTRY'] . ' ' . $company_address[2]['PROVINCE'] . ' ' . $company_address[2]['REGION'] . ' ' . $company_address[2]['ADDRESS_1'] . ' ' . $company_address[2]['ADDRESS_2'],
      "inn"=> $company_requisite['RQ_INN'],
      "kpp"=> $company_requisite['RQ_KPP'],
      "ogrn"=> $company_requisite['RQ_OGRNIP'],
      "okpo"=> $company_requisite['RQ_OKPO'],
    ], JSON_UNESCAPED_UNICODE );

    $url = "https://online.moysklad.ru/api/remap/1.1/entity/counterparty";
    $res = callAPI('POST', $url, $data);
    callMethod('crm.company.update',[
        'id'=> $company_id,
        'fields' => [
            'UF_CRM_1581348291' => $res['id'],
            'UF_CRM_1581348521' => $res['accountId'],
            ],
    ]);
    logData($res);
}
if (isset($_REQUEST['event']) && $_REQUEST['event'] == 'ONCRMDEALADD') {
    $deal_id = $_REQUEST['data']['FIELDS']['ID'];
    $deal = callMethod('crm.deal.get',[
        'id' => $deal_id
    ]);
    $company = callMethod('crm.company.list',[
        'filter' => [ 'ID' => $deal['COMPANY_ID'], ],
        'select' => ['*', 'UF_*', 'PHONE', "EMAIL"]
    ])[0];
    $data = [
        "name"=> $deal['TITLE'],
        "organization"=> [
            "meta"=> [
                "href"=> "https://online.moysklad.ru/api/remap/1.1/entity/organization/a909f9b9-b4fa-11e9-912f-f3d400027bbd",
                "type"=> "organization",
                "mediaType"=> "application/json"
            ]
        ],
        "agent"=> [
            "meta"=> [
                "href"=> "https://online.moysklad.ru/api/remap/1.1/entity/counterparty/".$company['UF_CRM_1581348291'],
                "type"=> "counterparty",
                "mediaType"=> "application/json"
            ]
        ],
        'positions' => []
    ];
    $productPositions = callMethod('crm.deal.productrows.get',[
        'id' => $company['ID']
    ]);
    foreach ($productPositions as $key => $val){
        $productDescriptions = callMethod('crm.product.get',[
            'id' => $val['ID']
        ]);
        array_push($data['positions'], [
                "quantity"=> $val['QUANTITY'],
                "assortment"=> [
                    "meta"=> [
                        "href"=> "https://online.moysklad.ru/api/remap/1.1/entity/product/" . $productDescriptions['PROPERTY_103']['value'],
                        "type"=> "product",
                        "mediaType"=> "application/json"
                    ]
                ],
        ]);

    }
    logData($data);
    $url =  'https://online.moysklad.ru/api/remap/1.1/entity/customerorder';
    $res = callAPI('POST', $url, json_encode($data, JSON_UNESCAPED_UNICODE ));
    callMethod('crm.deal.update', [
        'id' => $deal_id,
        'fields' => [
            //MoySkladDealAccountId
            'UF_CRM_1581413740' => $res['id'],
            //MoySkladDealId
            'UF_CRM_1581413722' => $res['accountId']
        ]
    ]);
    logData($res);

}