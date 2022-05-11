<?php


/**
 * File name: ModulbankPayController.php
 * Last modified: 06.11.2020 at 10:00:00
 * Author: Revoltiks revoltiks.mobile@gmail.com
 * Copyright (c) 2020
 */

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Repositories\DeliveryAddressRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Modulbank;


class ModulbankPayController extends ParentOrderController
{

    public function index()
    {
        return view('welcome');
    }


    public function checkout(Request $request)
    {
        try{
            $user = $this->userRepository->findByField('api_token', $request->get('api_token'))->first();
            $coupon = $this->couponRepository->findByField('code', $request->get('coupon_code'))->first();
            $deliveryId = $request->get('delivery_address_id');

            if (!empty($user)) {
                $this->order->user = $user;
                $this->order->user_id = $user->id;
                $this->order->delivery_address_id = $deliveryId;
                $this->coupon = $coupon;

                $dataCallback = [
                    'user_id'=>$user->id,
                    'delivery_address_id'=>$deliveryId
                ];
                if (isset($this->coupon)){
                    $dataCallback['coupon_code'] = $this->coupon->code;
                }

                $orderId = ($this->paymentRepository->all()->count() + 1) . '-' . $user->id . '.' .time();
                return view('modulbank.checkout', [
                    'form' => Modulbank::form(
                        $orderId,
                        $this->calculateTotal(),
                        $user,
                        $this->order->user->cart,
                        $this->coupon,
                        $dataCallback
                    )]);

            }
        }catch (\Exception $e){
            Flash::error("Error processing ModulbankPay payment for your order :" . $e->getMessage());
            return redirect(route('payments.failed'));
        }

        Flash::error("Error processing ModulbankPay user not found");
        return redirect(route('payments.failed'));
    }

    /**
     * @param int $userId
     * @param int $deliveryAddressId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paySuccess(Request $request, int $userId, int $deliveryAddressId = null, string $couponCode = null)
    {
        $data = $request->all();

        $this->order->user_id = $userId;
        $this->order->user = $this->userRepository->findWithoutFail($userId);
        $this->coupon = $this->couponRepository->findByField('code', $couponCode)->first();
        $this->order->delivery_address_id = $deliveryAddressId;

        $modulbankTransactionStatus = Modulbank::getTransactionStatus($data['transaction_id']);

        if ($modulbankTransactionStatus && $modulbankTransactionStatus->transaction->state == 'COMPLETE') {

            $description = $this->getPaymentDescription($data['transaction_id'], $modulbankTransactionStatus->transaction);

            $this->order->payment = new Payment();
            $this->order->payment->status = trans('lang.order_paid');
            $this->order->payment->method = 'ModulbankPay';
            $this->order->payment->description = $description;

            $this->createOrder();

            return redirect(url('payments/modulbank'));
        }

        Flash::error("Error processing Modulbank payment for your order");
        return redirect(route('payments.failed'));
    }

    /**
     * @param object $data
     * @return string
     */
    private function getPaymentDescription($payment_id, $data): string
    {
        $description = "pan_mask: " . $data->pan_mask . "</br>";
        $description .= "DepositAmount: " . ($data->amount) . "</br>";
        $description .= "Id: " . $payment_id . "</br>";
        $description .= $data->description . "</br>";
        $description .= $data->client_name .' '. $data->client_phone.' ' . $data->client_email. "</br>";
        return $description;
    }

    public function __init()
    {
        // TODO: Implement __init() method.
    }

}
