<?php

namespace App;

class BitrixQuery
{
	public static function callMethod($method, $params, $totals=null , $toggle='json') {

        global $not_to_die;
        $response = BitrixQuery::request($method, $params, $toggle);
        $count = 0;
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
            $response = BitrixQuery::request($method, [$params,
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
        return $fullResponse;
    }

    public static function request($method, $params , $toggle = 'json' ) {
        $params = http_build_query($params);
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
}
