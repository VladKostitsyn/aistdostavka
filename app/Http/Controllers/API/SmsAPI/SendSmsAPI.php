<?php

namespace App\Http\Controllers\API\SmsAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SmsAuth\SmsAuthRepository as SMS;
class SendSmsAPI extends Controller
{
    public function index(Request $request, SMS $send){
      /*  */
        $number='+7'.$request->phone;
        $response = $send->sendSMS($request->phone);
        return  response()->json($response);

    }

    public function chekDisableSms(){
        /*  */
        return response()->json(setting('disable_sms_verification'));

    }
}
