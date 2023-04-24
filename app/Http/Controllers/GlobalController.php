<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Session;
class GlobalController extends Controller {
    public $successStatus   = 200;
    public $errorStatus     = 200;
    public function getStudentPracticeAnswer(Request $request) {
        $sessionAll = Session::all();
        $request_payload = array();
        $request_payload['student_id']      = Session::get('user_id_new');
        $request_payload['token_app_type']  = 'ieuk_new';
        $request_payload['token']           = Session::get('token');
        $request_payload['course_id']       = $sessionAll['course_id_new'];
        $request_payload['level_id']        = $sessionAll['level_id_new'];
        $request_payload['task_id']         = $request['task_id'];
        $request_payload['practise_id']     = $request['practise_id'];
        $request_payload['topic_id']        = $request['topic_id'];
        $endPoint                           = "student-practice-answer";
        $response                           = curl_get($endPoint, $request_payload);
        if (!$response['success']){
            return  response()->json($response);
        }
        return  response()->json( $response['result']);
    }
    public function saveStudentSelfMarkingForm(Request $request) {
        $request_payload = array();
        $request_payload['student_id']      = Session::get('user_id_new');
        $request_payload['practise_id']     = $request['practise_id'];
        $request_payload['marks_gained']    = $request['marks'];
        $request_payload['token_app_type']  = 'ieuk_new';
        $request_payload['token']           = Session::get('token');
        $endPoint                           = "practisesubmitmarking_new";
        $response                           = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
}
