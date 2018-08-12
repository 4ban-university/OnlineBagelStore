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
            $table->dropColumn('delivery_address')->nullable();
            $table->integer('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('apartment')->nullable();
            $table->string('postcode')->nullable();
            $table->string('province')->nullable();
        });

        Schema::table('users', function($table) {
            $table->integer('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->string('apartment')->nullable();
            $table->string('postcode')->nullable();
            $table->string('province')->nullable();
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
