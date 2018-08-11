<?php

use Faker\Generator as Faker;

$factory->define(App\OrderItem::class, function (Faker $faker) {
    return [
        'product_id'  => $faker->numberBetween(1, 20),
        'order_id'  => $faker->numberBetween(1, 30),
        'amount'    => $faker->numberBetween(1, 6)
    ];
});
