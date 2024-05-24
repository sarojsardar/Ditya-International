<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DemandNotification extends Notification
{
    use Queueable;

    public $demand;

    public function __construct($demand)
    {
        $this->demand = $demand;
    }

    public function via($notifiable)
    {
        return ['mail']; // Adjust based on your notification channels (e.g., database, SMS)
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('There is a new demand notification.')
            ->action('View Demand', url('/demands/' . $this->demand->id))
            ->line('Thank you for using our application!');
    }
}
