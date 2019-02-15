<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  public $timestamps = false;
  protected $fillable=[
    'user_id','messageBody','created_at'
  ];
  public function user(){
        return $this-> belongsTo('App\User');
    }
}
