<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // function callBatch($data = array()){
    //     if (empty($data)) exit;
    //     return requestBatch($data);
    // }
    // function requestBatch($data) {
    //   $cmd = 'halt=0';
         // foreach ($data as $key => $value) {
         //     $cmd .= '&cmd['.$key.']='.urlencode($value[0]);
         // }

         // $url = 'https://miratrans.bitrix24.ru/rest/1/u0rn8tnbt3xiski4/batch.json?'.$cmd;
         // echo $url;

         // $ch = curl_init();
         // curl_setopt($ch, CURLOPT_URL, $url);
         // curl_setopt($ch, CURLOPT_HEADER, 0);
         // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         // $response = json_decode(curl_exec($ch), true);
         // curl_close($ch);
         // return $response;
    // }
function callAPI($method, $url, $data){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode('admin@9032330307:A1234567890q'),
        'Content-Type: application/json',
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return json_decode($result, true);
}

    function callMethod($method, $params, $totals=null , $toggle = 'json' ) {

        global $not_to_die;
        $response = request($method, $params , $toggle);
        $count = 0;
        // if (!isset($response['result'])) {
        //     if ( ! isset( $not_to_die ) ) {
        //         die( 'result isnt set err in curl.php!' );   
        //     } else {
        //         return $response[ 'result' ];
        //     }
        // }
        if($toggle === 'xml') return $response;
        $fullResponse = '';
        if (!isset($totals)) {
            if (!isset($response['result'])) {
                if (isset($response['error_description'])) {
                    $fullResponse = $response['error_description'];
                }
            } else {
                $fullResponse = $response['result'];
            }
        } else {
            $fullResponse = $response['total'];
        }
        
        while (isset($response['next'])) {
            // sleep(1);
            $response = request($method, [$params,
                'start' => $response['next']
            ]);
            if (!isset($totals)) {
                if (!isset($response['result'])) {
                    if (isset($response['error_description'])) {
                        $fullResponse = array_merge($response, $fullResponse);
                    }
                } else {
                    $fullResponse = array_merge($response['result'], $fullResponse);
                }
            } else {
                $fullResponse = array_merge($response['total'], $fullResponse);
            }
        }
    
        if (!$fullResponse) {
            return;
        }
        // logData($fullResponse);
        return $fullResponse;
    }
    
    function request($method, $params , $toggle = 'json' ) {       
        $params = http_build_query($params);
        // var_dump($params);
        // $url = 'https://crm-strategy.bitrix24.ru/rest/18/j6g3pg2di2d3waax/'.$method.'.json?'.$params;
        $url = 'https://gigstroy.bitrix24.ru/rest/1/2je1wrfo76ic4oi4/'.$method.'.' . $toggle . '?'.$params;
        // echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if ( $toggle == 'xml' ) {
            $response = curl_exec($ch);
        } else {
            $response = json_decode(curl_exec($ch), true);
        }
        curl_close($ch);
        return $response;
    }


?>