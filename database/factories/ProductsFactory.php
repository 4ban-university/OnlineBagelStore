<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'calories' => $faker-> numberBetween(100, 300),
        'description'=> $faker->text(30),
        'price'=> $faker->randomFloat(2,5, 10),
        'type'=> $faker->randomFloat(0,1, 2),
        'image'=>'https://picsum.photos/600/300/?image='.$faker->numberBetween(1, 100)
    ];
});
