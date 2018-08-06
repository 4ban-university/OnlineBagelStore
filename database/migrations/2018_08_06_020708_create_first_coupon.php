<?php

use App\Coupon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $coupon = new Coupon;
        $coupon->name = "SOEN6011";
        $coupon->percent = 10;
        $coupon->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Coupon::all()->delete();
    }
}
