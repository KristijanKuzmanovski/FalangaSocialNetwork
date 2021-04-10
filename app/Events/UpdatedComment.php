<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Comment;

class UpdatedComment implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
//TODO:Make the channels private
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public $comment;

  public function __construct(Comment $comment)
  {
      $this->comment=$comment;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
      return new PrivateChannel('FalangaComment.'.$this->comment->post_id);
  }
  public function broadcastAs(){
    return 'UpdatedComment';
  }
  public function broadcastWith(){
    return [
      'username'=>$this->comment->user->name,
      'commentBody'=>$this->comment->commentBody,
      'created_at'=>$this->comment->created_at->toDateTimeString(),
      'post_id'=>$this->comment->post_id,
      'user_id'=>$this->comment->user_id,
      'comment_id'=>$this->comment->id,
      'profile_pic'=>'/images/profiles/'.$this->comment->user->profile_pic
    ];
  }
}
