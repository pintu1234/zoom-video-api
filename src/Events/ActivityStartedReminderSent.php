<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Helper;
use App\Models\User;

class ActivityStartedReminderSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $message = 'The activity '.$event->activity->title.' is started';
        $title = $event->activity->title;
        $helper = new Helper();
        
        foreach ($event->patient as $key => $value) {
            $token = $value->device_token;
            $web_token = $value->web_token;

            if ($token) {
                $helper->sendNotification($token, $title, $event, 1);
            }

            if ($web_token) {
                $helper->sendWebNotification($web_token, $title, $event, 1);
            }
        }
    }
}
