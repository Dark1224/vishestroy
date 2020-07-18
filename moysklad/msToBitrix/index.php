<?php
include_once '../curl.php';
include_once '../log.php';
$request = file_get_contents('php://input');
if ($request != '' || !empty($request)){
    $request = json_decode($request, true);
    $url = $request['events'][0]['meta']['href'];
    $res = callAPI('PUT', $url, false);
    $stage_url = $res['state']['meta']['href'];
    $stage = callAPI('PUT', $stage_url, false);
    if($stage['name'] == 'Новый'){
        $bx_stage = 'NEW';
    }else if($stage['name'] == 'Подтвержден'){
        $bx_stage = 'PREPARATION';
    }else if($stage['name'] == 'Собран'){
        $bx_stage = 'PREPAYMENT_INVOICE';
    }else if($stage['name'] == 'Отгружен'){
        $bx_stage = 'EXECUTING';
    }else if($stage['name'] == 'Доставлен'){
        $bx_stage = 'WON';
    }else if($stage['name'] == 'Возврат'){
        $bx_stage = 'LOSE';
    }else if($stage['name'] == 'Отменен'){
        $bx_stage = 'APOLOGY';
    }
    $deal = callMethod('crm.deal.list', [
        'filter' => ['UF_CRM_1581413740' => $res['id']],
        'select' => ['ID']
    ])[0];
    $bx_res = callMethod('crm.deal.update', [
        'id' => $deal['ID'],
        'fields' => [
            'STAGE_ID' => $bx_stage
        ]
    ]);
    logData($bx_res);
}