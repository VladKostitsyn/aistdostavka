<?php

namespace App\Http\Controllers\API\NewCoponLogick;

use App\Models\Coupon;
use App\Models\CouponUsed;
use App\Repositories\CouponRepository;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use mysql_xdevapi\Exception;

class NewCoponsLogickAPI extends Controller
{
    public function index(Request $request){
        /*  */
        return ;

    }
    public function checkUseCoupone(Request $request, CouponRepository $couponRepository)
    {
        $userId = $request->userId;
        $couponCode = $request->couponCode;
        $test = Coupon::where('code', '=', $couponCode)->get('coupon_type');

        if ($test->isEmpty()){
            return  response()->json(false);
        }

        foreach ($test as $tests) {

                if ($tests->coupon_type == 'reusable') {
                    return response()->json(true);
                }

                if ($tests->coupon_type == 'disposable') {
                    $coupon = Coupon::where('code', '=', $couponCode)->whereHas('CouponUsed', function ($query) use ($userId) {
                        $query->where('user_id', '=', $userId);
                    })->get();
                    if ($coupon->isEmpty()) {
                        return response()->json(true);
                    } else {
                        return  response()->json(false);

                    }
                }
                if ($tests->coupon_type == 'disposable_one') {
                    $coupon = Coupon::where('code', '=', $couponCode)->has('CouponUsed', '>=', 1)->get();

                    if ($coupon->isEmpty()) {
                        return response()->json(true);
                    } else {
                        return  response()->json(false);
                    }

                }


        }
    }
}
