<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable,HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profile_pic','profile_bio','asked','lastRead'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 public function posts(){
      return $this-> hasMany('App\Post');
  }
  public function votes(){
      return $this-> hasMany('App\Vote');
  }
  public function comments(){
      return $this-> hasMany('App\Comment');
  }
  public function messages(){
      return $this-> hasMany('App\Message');
  }
}
