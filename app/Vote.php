<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public $timestamps = false;
    protected $fillable=[
      'user_id','post_id','like','dislike'
    ];
    public function users(){
    return $this-> belongsTo('App\User');
    }
    public function posts(){
    return $this-> belongsTo('App\Post');
    }
}
