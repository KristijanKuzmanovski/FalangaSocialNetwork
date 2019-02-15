<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween($min=1,$max=10),
        'post_id'=>$faker->numberBetween($min=1,$max=40),
        'commentBody'=>$faker->realText($maxNbChars=100,$indexSize=2)
    ];
});
