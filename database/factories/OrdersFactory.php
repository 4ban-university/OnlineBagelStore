<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'customer' => $faker->text(10),
        'promotion' => $faker->text(10),
        'price'=> $faker->randomFloat(2,5, 10),
        'street_number'=> $faker->randomFloat(0,1, 100),
        'street_name'=> $faker->text(10),
        'apartment'=> $faker->randomFloat(0,1, 100),
        'postcode'=> $faker->text(6),
        'province'=> 'QC',
        'payment_option' => $faker-> numberBetween(1, 4)
    ];
});
