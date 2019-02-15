<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Message;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
//TODO:Make the channels private
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;

    public function __construct(Message $mess)
    {
        $this->message=$mess;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('FalangaChat');
    }
    public function broadcastAs(){
      return 'NewMessage';
    }
    public function broadcastWith(){
      return [
        'username'=>$this->message->user->name,
        'messageBody'=>$this->message->messageBody,
        'created_at'=>$this->message->created_at,
        'message_id'=>$this->message->id,
        'user_id'=>$this->message->user->id
      ];
    }
}
