<?php

use Faker\Generator as Faker;

$factory->define(App\Message::class, function (Faker $faker) {
    return [
        'user_id'=>$faker->numberBetween($min=1,$max=10),
        'messageBody'=>$faker->realText($maxNbChars=40,$indexSize=1),
        'created_at'=>$faker->dateTime($max = 'now', $timezone = null)
    ];
});
