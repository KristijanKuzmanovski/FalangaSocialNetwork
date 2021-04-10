<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Vote;
use App\Post;
class NewVote implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $vote;
    public function __construct(Vote $vote)
    {
        $this->vote=$vote;
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
      return 'NewVote';
    }
    public function broadcastWith(){
      $post=Post::findOrFail($this->vote->post_id);
      return [
          'post_id'=>$this->vote->post_id,
          'user_id'=>$this->vote->user_id,
          'likes'=>$post->likes,
          'dislikes'=>$post->dislikes
      ];
    }
}
