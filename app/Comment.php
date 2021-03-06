<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
      'user_id','post_id','commentBody'
    ];
    public function user(){
        return $this-> belongsTo('App\User');
    }
    public function posts(){
        return $this-> belongsToMany('App\Post');
    }
}
