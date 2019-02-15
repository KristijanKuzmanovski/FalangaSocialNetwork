<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\NotificationModels\PostNotificationModel;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public $object;
    public function __construct(PostNotificationModel $tmp)
    {
        $this->object=$tmp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id'=>$this->object->user,
            'profile_pic'=>$this->object->profile_pic,
            'message'=>$this->object->message,
            'post_id'=>$this->object->post_id,
            'username'=>$this->object->username
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id'=>$this->object->user,
            'profile_pic'=>$this->object->profile_pic,
            'message'=>$this->object->message,
            'post_id'=>$this->object->post_id,
            'username'=>$this->object->username
        ];
    }
}
