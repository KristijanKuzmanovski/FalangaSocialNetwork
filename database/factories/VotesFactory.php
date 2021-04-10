<?php

use Faker\Generator as Faker;

$factory->define(App\Vote::class, function (Faker $faker) {
    $num=rand(0,2);
    $like=0;
    $dislike=0;
    if($num === 0){
      $like=1;
      $dislike=0;
    }elseif ($num === 1) {
      $like=0;
      $dislike=1;
    }
    return [
        'user_id'=>$faker->numberBetween($min=1,$max=10),
        'post_id'=>$faker->numberBetween($min=1,$max=40),
        'like'=>$like,
        'dislike'=>$dislike
    ];
});
