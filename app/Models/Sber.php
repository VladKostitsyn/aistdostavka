<?php

namespace App\Models;

class Sber
{

    private static $path_api = "https://securepayments.sberbank.ru";
    private static $path_api_test = "https://3dsec.sberbank.ru";

    public static function registerOrder($total, $orderId, $dataCallback, $pageView = 'MOBILE'){

        $apiUrl = setting('enable_sber_production', 0) ? self::$path_api : self::$path_api_test;
        $returnUrl = url('payments/sberpay/pay-success',$dataCallback);

        $url = $apiUrl
            ."/payment/rest/register.do?amount=".intval($total)."00&currency=643&language=ru&orderNumber=".$orderId
            ."&password=".rawurlencode(setting('sber_pass', ''))
            ."&userName=".rawurlencode(setting('sber_login', ''))
            ."&returnUrl=".rawurlencode($returnUrl)
            ."&pageView=".$pageView
            ."&sessionTimeoutSecs=1200";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public static function reverseOrder($orderId){

        $apiUrl = setting('enable_sber_production', 0) ? self::$path_api : self::$path_api_test;

        $url = $apiUrl
            ."/payment/rest/reverse.do?language=ru"
            ."&password=".rawurlencode(setting('sber_pass', ''))
            ."&userName=".rawurlencode(setting('sber_login', ''))
            ."&orderId=".$orderId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    public static function paymentDo($orderId, $payData){

        $apiUrl = setting('enable_sber_production', 0) ? self::$path_api : self::$path_api_test;

        $payToken = $payData[0]['value'];

        $postData = json_encode([
            "merchant" => setting('sber_merchant'),
            "orderNumber" => $orderId,
            "paymentToken" => $payToken,
            "language" => "ru",
            "preAuth" => "false"
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl."/payment/applepay/payment.do");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);


        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);

    }

    public static function getOrderStatus( $orderId ) {

        $apiUrl = setting('enable_sber_production', 0) ? self::$path_api : self::$path_api_test;

        $url = $apiUrl
            . "/payment/rest/getOrderStatus.do?orderId=" . $orderId
            ."&language=ru"
            ."&password=".rawurlencode(setting('sber_pass', ''))
            ."&userName=".rawurlencode(setting('sber_login', ''));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    public static function getOrderStatusExtended($SberOrderId, $orderNumber)
    {

        $apiUrl = setting('enable_sber_production', 0) ? self::$path_api : self::$path_api_test;

        $url = $apiUrl
            . "/payment/rest/getOrderStatusExtended.do?orderId=" . $SberOrderId
            . "&language=ru&orderNumber=" . $orderNumber
            ."&password=".rawurlencode(setting('sber_pass', ''))
            ."&userName=".rawurlencode(setting('sber_login', ''));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

}
