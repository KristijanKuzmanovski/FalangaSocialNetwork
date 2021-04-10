<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\NotificationModels\CommentedOnPostModel;

class CommentedOnPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public $object;
    public function __construct(CommentedOnPostModel $tmp)
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
