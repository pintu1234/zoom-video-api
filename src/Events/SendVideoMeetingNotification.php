<?php

namespace Hcbszoom\Zoom\Events;

use App\Jobs\SendVideoMeetingJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Helper;
use App\Models\User;

class SendVideoMeetingNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$title,$message)
    {
        $users = User::get();

        foreach ($users as $user) {

            $token = $user->device_token;
            $web_token = $user->web_token;

            $helper = new Helper();

            if ($token) {
                if ($user->device_type==="2"){

                    $helper->sendIosNotification($token, $title,$message , $data, 2);
                }else{
                    $helper->sendNotification($token, $title , $data, 2);
                }
            }

            if ($web_token) {
                $helper->sendWebNotification($web_token, $title, $data, 2);
            }
        }
    }
}
