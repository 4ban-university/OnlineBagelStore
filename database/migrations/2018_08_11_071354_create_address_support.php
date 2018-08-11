<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function($table) {
            $table->dropColumn('delivery_address');
            $table->integer('street_number');
            $table->string('street_name');
            $table->string('apartment');
            $table->string('postcode');
            $table->string('province');
        });

        Schema::table('users', function($table) {
            $table->integer('street_number');
            $table->string('street_name');
            $table->string('apartment');
            $table->string('postcode');
            $table->string('province');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
