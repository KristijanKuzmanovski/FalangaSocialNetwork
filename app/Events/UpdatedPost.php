<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Post;

class UpdatedPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //TODO:Make the channels private
      /**
       * Create a new event instance.
       *
       * @return void
       */
      public $post;

      public function __construct(Post $post)
      {
          $this->post=$post;
      }

      /**
       * Get the channels the event should broadcast on.
       *
       * @return \Illuminate\Broadcasting\Channel|array
       */
      public function broadcastOn()
      {
        return new PresenceChannel('FalangaFeed');
      }
      public function broadcastAs(){
        return 'UpdatedPost';
      }
      public function broadcastWith(){
        return [
          'username'=>$this->post->user->name,
          'postBody'=>$this->post->postBody,
          'created_at'=>$this->post->updated_at->toDateTimeString(),
          'likes'=>$this->post->likes,
          'dislikes'=>$this->post->dislikes,
          'comments'=>$this->post->comments,
          'post_id'=>$this->post->id,
          'user_id'=>$this->post->user_id,
          'profile_pic'=>'/images/profiles/'.$this->post->user->profile_pic
        ];
      }
}
