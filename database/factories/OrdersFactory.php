<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer' => $faker->text(10),
        'promotion' => $faker->text(10),
        'price'=> $faker->randomFloat(2,5, 10),
        'delivery_address'=> $faker->text(30),
        'payment_option' => $faker-> numberBetween(1, 4)
    ];
});
