<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserActionNotification extends Notification
{
    use Queueable;

    public $message;

    // 1. Pass data into the notification
    public function __construct($message)
    {
        $this->message = $message;
    }

    // 2. Specify we want to store this in the 'database'
    public function via($notifiable)
    {
        return ['database'];
    }

    // 3. Define the data structure for the database
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'link' => url('/'), // Optional: where the user goes when clicking
            'icon' => 'info',   // Optional: icon type
        ];
    }
}
