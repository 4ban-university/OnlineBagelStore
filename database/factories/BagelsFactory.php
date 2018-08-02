<?php

use Faker\Generator as Faker;

$factory->define(App\Bagel::class, function (Faker $faker) {
    return [
        'title' => $faker->text(10),
        'calories' => $faker-> numberBetween(100, 300),
        'description'=> $faker->text(30),
        'image'=>'https://picsum.photos/600/300/?image='.$faker->numberBetween(1, 100)
    ];
});
