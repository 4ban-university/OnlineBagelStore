<?php

use Faker\Generator as Faker;

$factory->define(App\OrderItemTopping::class, function (Faker $faker) {
    return [
        'order_item_id'  => $faker->numberBetween(1, 40),
        'topping_id'  => $faker->numberBetween(1, 10),
        'amount'    => $faker->numberBetween(1, 5)
    ];
});
