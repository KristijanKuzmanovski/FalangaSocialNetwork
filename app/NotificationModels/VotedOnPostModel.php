<?php

namespace App\NotificationModels;
use App\User;
use Carbon\Carbon;

class VotedOnPostModel{
  public $user;
  public $profile_pic;
  public $message;
  public $post_id;
  public $username;

  public function __construct(User $usr, $flag, $post)
   {
       $this->user=$usr->id;
       $this->profile_pic=$usr->profile_pic;
       $this->username=$usr->name;
       $this->post_id= $post;

       if($flag === "like"){
         $this->message=' has liked your post.';
       }else{
         $this->message=' has disliked your post.';
       }
   }
}
