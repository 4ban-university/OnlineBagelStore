<?php

use Faker\Generator as Faker;

$factory->define(App\Topping::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'calories' => $faker-> numberBetween(100, 300),
        'description'=> $faker->text(30),
        'allergyfree' => $faker->boolean(90)
    ];
});
