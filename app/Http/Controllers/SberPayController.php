<?php


/**
 * File name: ModulbankPayController.php
 * Last modified: 06.11.2020 at 10:00:00
 * Author: Revoltiks revoltiks.mobile@gmail.com
 * Copyright (c) 2020
 */

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sber;
use App\Models\User;
use App\Repositories\DeliveryAddressRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Redirect;
use App\Models\CouponUsed;

class SberPayController extends ParentOrderController
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
            $pickUpChoice = $request->get('pickup', 'no');
            $deliveryId = $request->get('delivery_address_id');

            if (!empty($user)) {
                $this->order->user = $user;
                $this->order->user_id = $user->id;
                $this->coupon = $coupon;
                $this->pickUpChoice = $pickUpChoice == 'yes';
                $this->order->delivery_address_id = $this->pickUpChoice ? 0 : $deliveryId;

                $dataCallback = [
                    'user_id' => $user->id,
                    'delivery_address_id'=> $deliveryId > 0 ? (int)$deliveryId : 0,
                    'coupon_code' => isset($this->coupon) ? $this->coupon->code : '_NOSETT_',
                    'pick_up_choice' => $this->pickUpChoice ? 'yes' : 'no'
                ];

                $orderId = ($this->paymentRepository->all()->count() + 1) . '-' . $user->id . '.' .time();
                $sberAnswer = Sber::registerOrder($this->calculateTotal(), $orderId, $dataCallback);

                if ($sberAnswer && isset($sberAnswer->formUrl)) {

                    return redirect()->away($sberAnswer->formUrl);
                }

                Flash::error("Error processing SberPay user not found");
                return redirect(route('payments.failed'));

            }else{
                Flash::error("Error processing SberPay user not found");
                return redirect(route('payments.failed'));
            }
        }catch (\Exception $e){
            Flash::error("Error processing SberPay payment for your order :" . $e->getMessage());
            return redirect(route('payments.failed'));
        }
    }

    /**
     * @param int $userId
     * @param int $deliveryAddressId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function paySuccess(Request $request, int $userId, int $deliveryAddressId = 0, string $couponCode = null, string $pickUpChoice = null)
    {
        $data = $request->all();

        $this->order->user_id = $userId;
        $this->order->user = $this->userRepository->findWithoutFail($userId);
        $this->coupon = $this->couponRepository->findByField('code', $couponCode)->first();
        $this->pickUpChoice = $pickUpChoice == 'yes';
        $this->order->delivery_address_id = $deliveryAddressId;

        $sberOrderStatus = Sber::getOrderStatus($data['orderId']);

        if ($sberOrderStatus && isset($sberOrderStatus->OrderNumber)
            && $sberOrderStatus->OrderStatus == 2
            && $sberOrderStatus->ErrorCode == 0
            && $sberOrderStatus->depositAmount	== $sberOrderStatus->Amount
            && $sberOrderStatus->ErrorMessage == 'Успешно'
        ) {

            $description = $this->getPaymentDescription($data['orderId'], $sberOrderStatus);

            $this->order->payment = new Payment();
            $this->order->payment->status = trans('lang.order_paid');
            $this->order->payment->method = ($this->pickUpChoice ? 'Самовывоз и' : 'Доставка и') . ' Сбербанк оплата';
            $this->order->payment->description = $description;

            $this->createOrder();

            return redirect(url('payments/sberpay'));
        }

        Flash::error("Error processing SberPay payment for your order");
        return redirect(route('payments.failed'));
    }

    /**
     * @param object $data
     * @return string
     */
    private function getPaymentDescription($sber_payment_id, $data): string
    {
        $description = "CardholderName: " . $data->cardholderName . "</br>";
        $description .= "DepositAmount: " . ($data->depositAmount / 100) . "</br>";
        $description .= "Id: " . $sber_payment_id . "</br>";
        $description .= trans('lang.order').": " . $data->OrderNumber;
        return $description;
    }

    public function __init()
    {
        // TODO: Implement __init() method.
    }
}
