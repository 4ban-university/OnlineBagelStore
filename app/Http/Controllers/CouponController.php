<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Check if a coupon exists.
     * If yes, return the percentage off, if not return 0.
     * @param Request $request
     * @return int
     */
    public function isValid(Request $request, $name)
    {
        $coupon = Coupon::where('name', $name)->first();

        if ($coupon) {
            return $coupon->percent;
        }

        return 0;
    }
}
