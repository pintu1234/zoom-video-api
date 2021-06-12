<?php

namespace Hcbszoom\Zoom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hcbszoom\Zoom\Calendar;
use Hcbszoom\Zoom\MeetingController;
//use Hcbszoom\Zoom\Events\SendVideoMeetingNotification;

use Carbon\Carbon;
class ZoomController extends Controller
{
    public function zoom(){
		return view('zoom::zoom');
	}
    
    public function zoomaAjaxList() {

        $status = 0;
        $message = "";
        $record = [];
        try {
            $result = Calendar::with(['virtualRoom'])->get();
            //echo json_encode($result);
            $response['data'] = $result;
            $response['status'] = 1;
            $response['message'] = "Success";
            echo json_encode($response);
                    
        } catch (Exception $e) {
            $response['result'] = '';
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
            echo json_encode($response);
        }
    }

    public function zoomGenerateSignature(Request $request)
    {
        date_default_timezone_set("UTC");
        $api_key = env('ZOOM_API_KEY');
        $api_secret = env('ZOOM_API_SECRET');
        $meeting_number = $request->meetingNumber;
        $role = $request->role;
        $time = time() * 1000;

        $data = base64_encode($api_key . $meeting_number . $time . $role);

        $hash = hash_hmac('sha256', $data, $api_secret, true);

        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);

        return response()->json([
            'signature' => rtrim(strtr(base64_encode($_sig), '+/', '-_'), '='),
            'meetingNumber' => $meeting_number,
            'api_key' => $api_key,
            'apiSecret' => $api_secret,
            'role' => $role,
        ],200);
    }
    public function calendar(){
        $data = Calendar::with('virtualRoom')->get();
        $result = ($data) ? $data : '';
        return view('zoom::calendar', ['result' => $result]);
    }
        public function store(Request $request)
    {
        $time = explode('-',$request['time']);
        //print_r($time);
        //$startDate_check = str_replace("-","/",$request['startDate']);
        $startDate = date('Y-m-d',strtotime($request['startDate']));
        $data_arr = array(
            'user_id'=>$request['user_id'],
            'title'=>$request['title'],
            'instructor_name'=>$request['instructor_name'],
            'notes'=>$request['notes'],
            'startDate'=>$startDate,
            'startTime'=>$time[0],
            'endTime'=>$time[1]
        );
        //$startDate_check = str_replace("-","/",$request['startDate']);
        $check_avltime = Calendar::where('startDate', '=',$startDate)->where('startTime', '<=', $time[0])->where('endTime', '>=', $time[1])->where('user_id', '=',$request['user_id'])->first();
        if($check_avltime){
            return response()->json(['status'=>false,'message'=>'Time is alerdy set.please change the time duration!'],200);
        }else{
            $data = $request->all();
                $calendar = Calendar::where('id',$data['id'])->first();
                if ($calendar===null) {
                   $calendar = new Calendar();
                }

                $calendar->user_id = $request->user_id;
                $calendar->title = $request->title;
                $calendar->instructor_name = $request->instructor_name;
                $calendar->notes = $request->notes;
                $calendar->startDate = $startDate;
                $calendar->startTime = $time[0];
                $calendar->endTime = $time[1];
                if ($calendar->save()) {
                    $meeting_date=Carbon::parse($startDate.' '.$time[0]);
                    $meetingController = new MeetingController();
                     $resp =  $meetingController->createMeeting([
                         'activity_id' => $calendar->id,
                         'topic' => $calendar->title,
                         'start_time'=>$meeting_date,
                         'agenda'=>'Doral Daycare'
                     ]);
                    $message = $request->title;
                    $title = "Your Activity has been created";
                     //event(new SendVideoMeetingNotification($calendar,$title,$message));

                    return response()->json(['status'=>true,'message'=>'activity create successfully!'],200);
                }
                return response()->json(['status'=>false,'message'=>'Something Went Wrong!'],422);
        }

    }
}
