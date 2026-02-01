<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserActionNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        // Example: ['message' => 'Saral liked your post.', 'url' => '/post/1']
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database']; // 💡 Only saving in database
    }

    /**
     * Get the array representation for storing in database.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->data['message'],
            'url' => $this->data['url'],
        ];
    }
}
