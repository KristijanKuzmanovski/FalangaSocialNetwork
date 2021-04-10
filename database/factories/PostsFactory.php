<?php

use Faker\Generator as Faker;
use App\Vote;
use App\Comment;


  $factory->define(App\Post::class, function (Faker $faker) {
    static $id=1;
    return [
      'user_id'=>$faker->numberBetween($min=1,$max=10),
      'postBody'=>$faker->realText($maxNbChars = 200, $indexSize = 2),
      'likes'=>Vote::where([['post_id',$id],['like',1]])->count(),
      'dislikes'=>Vote::where([['post_id',$id],['dislike',1]])->count(),
      'comments'=>Comment::where('post_id',$id)->count(),
      'id'=>$id++
    ];
});
