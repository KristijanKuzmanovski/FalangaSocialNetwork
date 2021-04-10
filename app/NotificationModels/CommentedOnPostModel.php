<?php

namespace App\NotificationModels;
use App\User;
use Carbon\Carbon;

class CommentedOnPostModel{
  public $user;
  public $profile_pic;
  public $message;
  public $post_id;
  public $username;

  public function __construct(User $usr,$post)
   {
       $this->user=$usr->id;
       $this->profile_pic=$usr->profile_pic;
       $this->username=$usr->name;
       $this->message=' has commented on your post.';
       $this->post_id= $post;
   }
}
