<?php

namespace App\Models;

use Illuminate\Support\Str;

class Modulbank
{
    const MODULE_VERSION = "0.0.1";
    const PATH_API = "https://pay.modulbank.ru";

    public static function form($order_id, $total, $user, $carts = null, $coupon = null, $dataCallback)
    {
        $sysinfo = [
            'language' => 'PHP ' . phpversion(),
            'plugin'   => 'ModulBank v' . self::MODULE_VERSION,
            'cms'      => 'FoodDelive.ru ' . setting('app_version', '2.5.0'),
        ];

        $data = [
            'action'         => self::PATH_API . '/pay',
            'button_confirm' => 'Отправить платеж',
            'form'           => [
                'merchant'        => setting('modulbank_merchant', ''),
                'amount'          => $total,
                'order_id'        => $order_id,
                'testing'         => setting('enable_modulbank_production', 0) ? 0 : 1,
                'description'     => 'Оплата заказа №' . ((int)$order_id),
                'success_url'     => url('payments/modulbank/pay-success', $dataCallback),
                'fail_url'        => url(route('payments.failed')),
                'cancel_url'      => url(route('payments.failed')),
//                'callback_url'    => '',
                'client_name'     => $user->name,
                'client_email'    => $user->email,
                'receipt_contact' => $user->email,
                //               'receipt_items'   => self::getReceiptItems($carts, $coupon),
                'unix_timestamp'  => time(),
                'sysinfo'         => json_encode($sysinfo, JSON_HEX_APOS),
                'salt'            => Str::random(20),
            ],
        ];

        $key = setting('enable_modulbank_production', 0) ? setting('modulbank_secure_key') : setting('modulbank_test_key');
        $data['form']['signature'] = self::calcSignature($key, $data['form']);
        $data['form']['sysinfo'] = htmlentities($data['form']['sysinfo']);
        //       $data['form']['receipt_items'] = htmlentities($data['form']['receipt_items']);

        return $data;
    }

    public static function calcSignature($secretKey, $params)
    {
        ksort($params);
        $chunks = array();
        foreach ($params as $key => $value) {
            $v = (string) $value;
            if (($v !== '') && ($key != 'signature')) {
                $chunks[] = $key . '=' . base64_encode($v);
            }
        }
        $signature = implode('&', $chunks);
        for ($i = 0; $i < 2; $i++) {
            $signature = sha1($secretKey . $signature);
        }
        return $signature;
    }


    public static function getReceiptItems($carts, $coupon)
    {
        $outputs = [];
        foreach ($carts as $_cart) {
            $price = $_cart->food->applyCoupon($coupon);
            foreach ($_cart->extras as $option) {
                $price += $option->price;
            }
            // https://dev.modulbank.ru/pages/viewpage.action?pageId=917558
            $outputs[] = [
                //       "discount_sum" => 40,
                "name"=> $_cart->food->name,
                "payment_method"=> "full_prepayment",
                "payment_object"=> "commodity",
                "price"=> $price,
                "quantity"=> $_cart->quantity,
                "sno"=> "osn",
                "vat"=> "none"
            ];
        }

        return json_encode($outputs, JSON_HEX_APOS);
    }

    public static function getTransactionStatus($transaction)
    {

        $key = setting('enable_modulbank_production', 0) ? setting('modulbank_secure_key') : setting('modulbank_test_key');
        $url  = self::PATH_API . '/api/v1/transaction';

        $data = [
            'merchant'       => setting('modulbank_merchant', ''),
            'transaction_id'    => $transaction,
            'unix_timestamp' => time(),
            'salt'           => Str::random(20),
        ];

        $data['signature'] = self::calcSignature($key, $data);
        $response = self::sendRequest('GET', $url, $data);
        return json_decode($response);
    }

    public static function sendRequest($method, $url, $data)
    {
        if ($method == 'GET') {
            $url .= "?".http_build_query($data);
        }
        $response = false;
        if (function_exists("curl_init")) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;
    }
}
