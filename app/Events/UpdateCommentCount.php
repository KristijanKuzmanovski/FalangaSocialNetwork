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

class UpdateCommentCount implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
      return [
        new PresenceChannel('FalangaFeed'),
        new PresenceChannel('FalangaProfile')
      ];
    }
    public function broadcastAs(){
      return 'UpdateCommentCount';
    }
    public function broadcastWith(){
      return [
          'post_id'=>$this->post->id,
          'comments'=>$this->post->comments
      ];
    }
}
