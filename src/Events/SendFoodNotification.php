<?php

namespace App\Events;

use App\Helpers\Helper;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendFoodNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($data,$userlist,$title=null,$message=null)
    {
        $title = 'Food Menu Notification';
        $message = 'Doral Day Care has created New Food Menu.Please select by going to Food Selection.';
        
        foreach ($userlist as $item) {
            $token = $item->device_token;
            if($token == '') {
                $token = $token;
            }
            $web_token=$item->web_token;
            $helper = new Helper();
             if ($item->device_type){

                $helper->sendIosNotification($token, $title,$message, $data, 2);
             }
            if ($web_token){
                $link=env('WEB_URL').'mealLists';
                $helper->sendWebNotification($web_token,$title,$message,$data,2,$link);
            }
        }
    }
}
