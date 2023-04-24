<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class SummaryController extends Controller {
    public function summary(Request $request) {
        $request        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint       = "individual_course_topic_list_new";
        $data           = curl_get($endPoint, $request);
        if(isset($data['invalid_token']) && $data['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$data['message']); 
        }
        $onlyCourse     = $data['new_result'];
        $request                    = array();
        $request['student_id']      = Session::get('user_id_new');
        $request['token_app_type']  = 'ieuk_new';
        $request['token']           = Session::get('token');
        $endPoint                   = "individual_getsummary_new";
        $response = curl_get($endPoint, $request);
        if (!$response['success']){
            $response['result'] = array();
        }
        $summary = $response['result'];
        $summarydata = array();
        foreach($summary as $key => $post){
            $summarydata[$key]['_id'] = $post['topics']['_id'];
            $summarydata[$key]['sorting'] = $post['topics']['sorting'];
            $summarydata[$key]['topicname'] = $post['topics']['topicname'];
            $summarydata[$key]['course_id'] = $post['course_id'];
        }
        $instration = isset($response['page_info'])?$response['page_info']:'';
        return view('dashboard.summary', compact('summary','onlyCourse','instration','summarydata'));
    }
    public function summary_post(Request $request) {
        $params = $request->all();
        $request = array();
        if(!isset($params['topic_id']) || empty($params['topic_id'])){
            return response()->json(['success'=>false,'message'=>'Please select topic.'], 200);
        }
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $request['topic_id'] = $params['topic_id'];
        $request['listening_summary'] = $params['listening_summary'];
        $request['reading_summary'] = $params['reading_summary'];
        $request['writing_summary'] = $params['writing_summary'];
        $request['speaking_summary'] = $params['speaking_summary'];
        $request['grammar_summary'] = $params['grammar_summary'];
        $request['vocabulary_summary'] = $params['vocabulary_summary'];
        $request['course_ids'] = $params['course_ids'];
        $request['level_ids'] = $params['level_ids'];
        Session::put('course_ids', $params['course_ids']);
        \Cache::forget('summarylist'.Session::get('user_id_new'));
        $endPoint = "individual_addsummary_new";
        $response = curl_post($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            Session::flash('alert-success', $response['message']);
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
}
    
