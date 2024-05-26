<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationEvent $event): void
    {
        $this->handleNow($event);
    }

    private function handleNow(NotificationEvent $event):void
    {
        switch ((int)$event->notification->send_to) {
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
